@extends('layouts.loginRegisterMain')

@section('content')
    <div class="register-container col-md-6 col-lg-7 d-flex align-items-center">
        <div class="p-4 p-lg-5 text-black card-body">
            <form action="/register/store" method="POST">
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
                        <select name="store_province" id="store_province" class="form-control" required value="{{ old('store_province') }}">
                            <option value="">Select Province</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                        <label for="store_province">Province</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="form-outline mb-3 form-floating">
                        <select name="store_city" id="store_city" class="form-control" required value="{{ old('store_city') }}">
                            <option value="">Select City</option>
                        </select>
                        <label for="store_city">City</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="form-outline mb-3 form-floating">
                        <select name="store_district" id="store_district" class="form-control" required value="{{ old('store_district') }}">
                            <option value="">Select District</option>
                        </select>
                        <label for="store_district">District</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="form-outline mb-3 form-floating">
                        <select name="store_subdistrict" id="store_subdistrict" class="form-control" required value="{{ old('store_subdistrict') }}">
                            <option value="">Select Subdistrict</option>
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
                    <p class="pb-lg-2" style="color: #5F5F5F;">Already have An Account? <a href="/login" class="text-decoration-none"
                        style="color: #F36600;">Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('custom_js')
    <script>
        $('form').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showSuccessAlert();
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

        // Fungsi untuk menampilkan popup register berhasil
        function showSuccessAlert() {
            Swal.fire({
                icon: 'success',
                title: 'Thank You For Your Registration!',
                text: 'Thank you for registering your shop on our website. Please check your email within 1-2 days to find out the status of the store',
                confirmButtonText: 'Back',
                confirmButtonColor: '#F36600',
            }).then((result) => {
                window.location.href = '/login';
            });
        }

        $('#store_province').change(function() {
            var provinceId = $(this).val();
            //Reset options
            $('#store_city').empty().append('<option value="">Select City</option>');
            $('#store_district').empty().append('<option value="">Select District</option>');
            $('#store_subdistrict').empty().append('<option value="">Select Subdistrict</option>');

            if (provinceId) {
                $.ajax({
                    url: "{{ route('store.getCity') }}",
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        id: provinceId,
                    },
                    success: function(data) {
                        data.forEach(function(city) {
                            $('#store_city').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    }
                });
            }
        });

        $('#store_city').change(function() {
            var cityId = $(this).val();
            //Reset options
            $('#store_district').empty().append('<option value="">Select District</option>');
            $('#store_subdistrict').empty().append('<option value="">Select Subdistrict</option>');

            if (cityId) {
                $.ajax({
                    url: "{{ route('store.getDistrict') }}",
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        id: cityId,
                    },
                    success: function(data) {
                        data.forEach(function(district) {
                            $('#store_district').append('<option value="' + district.id + '">' + district.name + '</option>');
                        });
                    }
                });
            }
        });

        $('#store_district').change(function() {
            var districtId = $(this).val();
            //Reset options
            $('#store_subdistrict').empty().append('<option value="">Select Subdistrict</option>');

            if (districtId) {
                $.ajax({
                    url: "{{ route('store.getSubdistrict') }}",
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        id: districtId,
                    },
                    success: function(data) {
                        data.forEach(function(subdistrict) {
                            $('#store_subdistrict').append('<option value="' + subdistrict.id + '">' + subdistrict.name + '</option>');
                        });
                    }
                });
            }
        });
    </script>
@endpush
