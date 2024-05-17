<div class="modal-content text-white" id="store_modal" style="background-color: #363636;">
    <div class="modal-body mb-3">
        @if(auth()->check())
            @if(auth()->user()->isAdmin() || auth()->user()->isUser())
                <div class="btn-close-user mb-4">
                    <button type="button" class="btn-close btn-close-red" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="d-flex">
                    <!-- Konten upload image -->
                    <div class="upload-image-container col-md-4 d-flex flex-column">
                        <div class="upload-image d-flex flex-column mt-3">
                            <img id="image_profile" src="{{ asset('img/login/profile.jpg') }}" class="rounded mb-3" alt="Image Profile" width="250" height="200" onerror="this.onerror=null;this.src='{{ asset('img/login/profile.jpg') }}';">
                        </div>
                        <div class="btn-sign-out d-flex">
                            <button id="btnSignOut" class="btn btn-secondary btn-SignOut" type="button">
                                <i class="fas fa-sign-out-alt" style="color: red;"></i> Sign Out
                            </button>
                        </div>
                    </div>
                    <!-- Profile untuk Admin && User -->
                    <div class="profile-form col-md-7">
                        <div class="col-md-12" style="padding: 1rem 2rem 1rem 2rem;">
                            <div class="title-form d-flex align-items-left">
                                <span class="h1 fw-bold mb-0">EDIT PROFILE</span>
                            </div>
                            <form id="edit-profile-form" action="{{ auth()->user()->isAdmin() ? route('admin.editProfile') : route('user.editProfile') }}" method="POST" class="d-flex flex-column" enctype="multipart/form-data">
                                @csrf
                                <div class="field-form">
                                    <label class="label-form-user text-light" for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="" required value="{{ $user->name }}"/>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="field-form">
                                    <label class="label-form-user text-light" for="store_phone">Username</label>
                                    <input type="tel" name="username" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="" required value="{{ $user->username }}"/>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="field-form">
                                    <label class="label-form-user text-light" for="email">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="" required value="{{ $user->email }}"/>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 pt-1 mb-2 d-flex justify-content-end">
                                    <button id="btnSubmit" class="btn text-light" style="background-color: #F36600;" type="button">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif(auth()->user()->isStore())
                <!-- Profile untuk Store -->
                <div class="profile-container">
                    <div class="title-form d-flex align-items-left">
                        <span class="h1 fw-bold mb-0">STORE EDIT PROFILE</span>
                    </div>
                    <button type="button" class="btn-close btn-close-red" data-bs-dismiss="modal" aria-label="Close"></button>
                    <form id="edit-profile-form" action="{{ route('store.editProfile') }}" method="POST" class="d-flex flex-column align-items-center" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="store_id" value="{{ $store->store_id }}">
                        <div class="d-flex">
                            <!-- Konten profile form -->
                            <div class="profile-form-store col-md-7">
                                <div class="store-detail d-flex flex-wrap justify-content-between" id="{{ $store->store_id }}">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6" style="padding-right: 15px;">
                                        <div class="field-form">
                                            <label class="label-form" for="store_name">Store Name</label>
                                            <input type="text" name="store_name" id="store_name" class="form-control @error('store_name') is-invalid @enderror" placeholder="" required value="{{ $store->store_name }}"/>
                                            @error('store_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="field-form">
                                            <label class="label-form" for="store_phone">Store Phone Number</label>
                                            <input type="tel" name="store_phone" id="store_phone" class="form-control @error('store_phone') is-invalid @enderror" placeholder="" required value="{{ $store->store_phone }}"/>
                                            @error('store_phone')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="field-form">
                                            <label class="label-form" for="email">Email Address</label>
                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="" required value="{{ $store->store_email }}"/>
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="field-form">
                                            <label class="label-form" for="store_province">Province</label>
                                            <div class="dropdown-wrapper">
                                                <select name="store_province" id="store_province" class="form-control @error('store_province') is-invalid @enderror" required>
                                                    <option value="">**Select Province**</option>
                                                    @foreach($provinces as $province)
                                                        <option {{ $store->store_province == $province->id ? 'selected' : '' }} value="{{ $province->id }}">{{ $province->name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fas fa-chevron-down select-icon"></i>
                                                @error('store_province')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="field-form">
                                            <label class="label-form" for="store_city">City</label>
                                            <div class="dropdown-wrapper">
                                                <select name="store_city" id="store_city" class="form-control @error('store_city') is-invalid @enderror" required>
                                                    <option value="">**Select City**</option>
                                                    @foreach($cities as $city)
                                                        <option {{ $store->store_city == $city->id ? 'selected' : '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fas fa-chevron-down select-icon"></i>
                                                @error('store_city')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="field-form">
                                            <label class="label-form" for="store_district">District</label>
                                            <div class="dropdown-wrapper">
                                                <select name="store_district" id="store_district" class="form-control @error('store_district') is-invalid @enderror" required>
                                                    <option value="">**Select District**</option>
                                                    @foreach($districts as $district)
                                                        <option {{ $store->store_district == $district->id ? 'selected' : '' }} value="{{ $district->id }}">{{ $district->name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fas fa-chevron-down select-icon"></i>
                                                @error('store_district')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <div class="field-form">
                                            <label class="label-form" for="store_subdistrict">Subdistrict</label>
                                            <div class="dropdown-wrapper">
                                                <select name="store_subdistrict" id="store_subdistrict" class="form-control @error('store_subdistrict') is-invalid @enderror" required>
                                                    <option value="">**Select Subdistrict**</option>
                                                    @foreach($subdistricts as $subdistrict)
                                                        <option {{ $store->store_subdistrict == $subdistrict->id ? 'selected' : '' }} value="{{ $subdistrict->id }}">{{ $subdistrict->name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fas fa-chevron-down select-icon"></i>
                                                @error('store_subdistrict')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="field-form">
                                            <label class="label-form" for="store_postal_code">Postal Code</label>
                                            <input type="text" name="store_postal_code" id="store_postal_code" class="form-control @error('store_postal_code') is-invalid @enderror" placeholder="" required value="{{ $store->store_postal_code }}"/>
                                            @error('store_postal_code')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="field-form">
                                            <label class="label-form" for="store_address">Store Address</label>
                                            <input type="text" name="store_address" id="store_address" class="form-control @error('store_address') is-invalid @enderror" placeholder="" required value="{{ $store->store_address }}"/>
                                            @error('store_address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="field-form">
                                            <label class="label-form" for="store_tokopedia">Store Tokopedia</label>
                                            <input type="url" name="store_tokopedia" id="store_tokopedia" class="form-control @error('store_tokopedia') is-invalid @enderror" placeholder="" required value="{{ $store->store_tokopedia }}"/>
                                            @error('store_tokopedia')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="field-form">
                                            <label class="label-form" for="store_shopee">Store Shopee</label>
                                            <input type="url" name="store_shopee" id="store_shopee" class="form-control @error('store_shopee') is-invalid @enderror" placeholder="" required value="{{ $store->store_shopee }}">
                                            @error('store_shopee')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="field-form">
                                            <label class="label-form" for="store_instagram">Store Instagram</label>
                                            <input type="text" name="store_instagram" id="store_instagram" class="form-control @error('store_instagram') is-invalid @enderror" placeholder="" required value="{{ $store->store_instagram }}"/>
                                            @error('store_instagram')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 pt-1 mb-2 d-flex justify-content-end">
                                        <button id="btnSubmit" class="btn text-light" style="background-color: #F36600;" type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Konten upload image -->
                            <div class="col-md-5 d-flex flex-column align-items-center">
                                <div class="upload-image-store d-flex flex-column align-items-center">
                                        <input type="hidden" name="store_id" value="{{ $store->store_id }}">
                                        @if($store->store_logo)
                                            <img id="output" src="{{ route('store.profileImage', ['imageName' => $store->store_logo]) }}" class="rounded mb-3" alt="Image Store Profile" width="250" height="200">
                                        @else
                                            <img id="output" src="{{ asset('img/login/profile.jpg') }}" class="rounded mb-3" alt="Image Profile" width="250" height="200" onerror="this.onerror=null;this.src='{{ asset('img/login/profile.jpg') }}';">
                                        @endif
                                        <label for="myFile" class="btn btn-primary" style="background-color:#F36600; border: 0px">
                                            Choose Image Profile
                                            <input type="file" id="myFile" name="filename" class="form-control file-input @error('filename') is-invalid @enderror" onchange="previewImage(event)" accept="image/jpeg, image/png, image/jpg" style="display: none;">
                                        </label>
                                        @error('filename')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                                <div class="btn-signOut-store d-flex">
                                    <button id="btnSignOut" class="btn btn-secondary btn-SignOut" type="button">
                                        <i class="fas fa-sign-out-alt" style="color: red;"></i> Sign Out
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @endif
    </div>
</div>
@push('content_profile_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .file-input {
            width: 85%;
        }

        .btn-close-red {
            background-color: red;
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .btn-SignOut, .btn-SignOut:hover{
            border-color:#FF0000;
            border-width: 2px;
        }

        .btn-signOut-store, .btn-sign-out {
            position: absolute;
            bottom: 0;
            margin-bottom: 2rem;
        }

        .title-form {
            padding: 0rem 0rem 1rem 0rem;
        }
        .upload-image-container {
            background-color: #000000;
            margin-right: 3rem;
            border-radius: 10px;
            height: 500px;
            align-items: center;
        }

        .profile-container {
            padding: 0rem 2rem 1rem 2rem;
        }

        .profile-form {
            background-color: #000000;
            border-radius: 10px;
            height: 25rem;
        }

        .profile-form-store {
            padding: 2rem 2rem 1rem 2rem;
            border-radius: 15px;
            margin-right: 3rem;
            background-color: white;
        }

        .field-form {
            padding-bottom: 1rem;
        }

        .label-form {
            color: black;
        }

        .dropdown-wrapper {
            position: relative;
        }

        .select-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
            color: black;
        }

        @media (min-width: 765px) {
            .modal-lg {
                --bs-modal-width: 1000px;
            }
        }
    </style>
@endpush
@push('content_profile_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if(session('success'))
                $('#profileModal').modal('show');

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#19B400',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'confirm-button-swal'
                    }
                });
            @elseif(session('error'))
                $('#profileModal').modal('show');

                Swal.fire({
                    icon: 'warning',
                    title: 'Failed',
                    text: 'Update failed. Please check your input.',
                    confirmButtonColor: '#19B400',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'confirm-button-swal'
                    }
                });
            @endif
        });


        $('#btnSubmit').click(function(){
            Swal.fire({
                title: 'Edit Profile',
                text: "Are you sure you want to update your profile?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#19B400',
                cancelButtonColor: '#FFFFFF',
                confirmButtonText: 'Approve',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'confirm-button-swal',
                    cancelButton: 'cancel-button-swal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#edit-profile-form').submit();
                }
            });
        });

        loadDataSelectAddress();

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var img = document.getElementById('output');
                img.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        $('#btnSignOut').click(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                },
                url: "{{ route('logout') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                },
                success: function(data) {
                    if (data.success) {
                        window.location.href = "{{ route('home') }}";
                    } else {
                        console.log("Logout gagal");
                    }
                }
            });
        });
    </script>
@endpush
