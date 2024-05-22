@extends('layouts.loginRegisterMain')

@section('content')
    <div class="register-container col-md-6 col-lg-7 d-flex align-items-center">
        <div class="p-4 p-lg-5 text-black card-body">
            <form action="{{ route('registerStore') }}" method="POST">
                @csrf
                <div class="d-flex align-items-center justify-content-center mb-3 pb-1">
                    <span class="h1 fw-bold mb-0">STORE REGISTER</span>
                </div>
                <div class="register-store overflow-auto">
                    <div class="form-outline mb-2 form-floating">
                        <input type="text" name="name" id="name" class="form-control" placeholder="" required value="{{ old('name') }}"/>
                        <label for="name">Store Name</label>
                    </div>
                    <div class="form-outline mb-2 form-floating">
                        <input type="tel" name="store_phone" id="store_phone" class="form-control" placeholder="" required value="{{ old('store_phone') }}"/>
                        <label for="store_phone">Store Phone Number</label>
                    </div>
                    <div class="form-outline mb-2 form-floating">
                        <input type="text" name="username" id="username" class="form-control" placeholder="" required value="{{ old('username') }}"/>
                        <label for="username">Username</label>
                    </div>
                    <div class="form-outline mb-2 form-floating">
                        <input type="email" name="email" id="email" class="form-control" placeholder="" required value="{{ old('email') }}"/>
                        <label for="email">Email Address</label>
                    </div>
                    <div class="form-outline mb-3 form-floating">
                        <select name="store_province" id="store_province" class="form-control" required>
                            <option value="">**Select Province**</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                        <label for="store_province">Province</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="form-outline mb-3 form-floating">
                        <select name="store_city" id="store_city" class="form-control" required>
                            <option value="">**Select City**</option>
                        </select>
                        <label for="store_city">City</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="form-outline mb-3 form-floating">
                        <select name="store_district" id="store_district" class="form-control" required>
                            <option value="">**Select District**</option>
                        </select>
                        <label for="store_district">District</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="form-outline mb-3 form-floating">
                        <select name="store_subdistrict" id="store_subdistrict" class="form-control" required>
                            <option value="">**Select Subdistrict**</option>
                        </select>
                        <label for="store_subdistrict">Subdistrict</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="form-outline mb-3 form-floating">
                        <input type="text" name="store_postal_code" id="store_postal_code" class="form-control" placeholder="" required value="{{ old('store_postal_code') }}"/>
                        <label for="store_postal_code">Postal Code</label>
                    </div>
                    <div class="form-outline mb-2 form-floating">
                        <input type="text" name="store_address" id="store_address" class="form-control" placeholder="" required value="{{ old('store_address') }}"/>
                        <label for="store_address">Store Address</label>
                    </div>
                    <div class="form-outline mb-2 form-floating">
                        <input type="url" name="store_tokopedia" id="store_tokopedia" class="form-control" placeholder="" required value="{{ old('store_tokopedia') }}"/>
                        <label for="store_tokopedia">Store Tokopedia</label>
                    </div>
                    <div class="form-outline mb-2 form-floating">
                        <input type="url" name="store_shopee" id="store_shopee" class="form-control" placeholder="" required value="{{ old('store_shopee') }}">
                        <label for="store_address">Store Shopee</label>
                    </div>
                    <div class="form-outline mb-2 form-floating">
                        <input type="text" name="store_instagram" id="store_instagram" class="form-control" placeholder="" required value="{{ old('store_instagram') }}"/>
                        <label for="store_address">Store Instagram</label>
                    </div>
                    <div class="form-outline mb-3 form-floating">
                        <input type="password" name="password" id="password" class="form-control" placeholder="" required/>
                        <label for="password">Password</label>
                    </div>
                    <div class="pt-1 mb-2">
                        <button class="btn text-light" style="background-color: #F36600;" type="submit">Register</button>
                    </div>
                    <p class="pb-lg-2" style="color: #5F5F5F;">Already have An Account? <a href="{{ route('view.login') }}" class="text-decoration-none"
                        style="color: #F36600;">Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('custom_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .register-store {
            height: 350px;
            overflow: scroll;
        }
        .register-store::-webkit-scrollbar {
            display: none;
        }
        .select-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }
    </style>
@endpush
@push('custom_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        loadDataSelectAddress();

        $('form').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showSuccessRegisterAlert();
                    }
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        $('.error-message').remove();
                        // Menampilkan error message
                        for (var fieldName in errors) {
                            var fieldErrors = errors[fieldName];
                            var errorMessage = fieldErrors.join(', ');
                            $('#' + fieldName).addClass('is-invalid').after('<div class="error-message">' + errorMessage + '</div>');
                        }
                        var firstErrorField = Object.keys(errors)[0];
                        $('#' + firstErrorField).focus();
                        $('.is-invalid').on('input', function() {
                            $(this).removeClass('is-invalid');
                            $(this).next('.error-message').remove();
                        });
                    }
                }
            });
        });
    </script>
@endpush
