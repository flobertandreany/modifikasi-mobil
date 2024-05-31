<div class="modal fade" id="popUpUserCar{{ $user_car->id }}" tabindex="-1" aria-labelledby="popUpUserCarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: #FBC536">
            <div class="modal-body">
                <div class="container" style="display: flex; justify-content: center;">
                    <div class="text-black card-body" style="width: 60%;">
                        <form action="{{ route('user.addUserCar') }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center justify-content-center pb-1">
                                <span class="add-new-car">Add New Car</span>
                            </div>
                            <div class="addCarModal overflow-auto">
                                <div class="form-outline mb-2 form-floating">
                                    <select name="car_year" id="car_year" class="form-control car-year-select" required>
                                        <option value="" hidden></option>
                                        @foreach($year as $y)
                                            <option value="{{ $y->car_year }}">{{ $y->car_year }}</option>
                                        @endforeach
                                    </select>
                                    <label style="font-size: larger;" for="car_year" >Car Year</label>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                                <div class="form-outline mb-2 form-floating">
                                    <select name="car_brand" id="car_brand" class="form-control car-brand-select" required>
                                        <option value="" hidden></option>
                                    </select>
                                    <label style="font-size: larger;" for="car_brand">Car Brand</label>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                                <div class="form-outline mb-2 form-floating">
                                    <select name="car_model" id="car_model" class="form-control car-model-select" required>
                                        <option value=""hidden ></option>
                                    </select>
                                    <label style="font-size: larger;" for="car_model">Car Model</label>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                                <div class="form-outline mb-2 form-floating">
                                    <select name="car_engine" id="car_engine" class="form-control car-engine-select @error('car_engine') is-invalid @enderror" required>
                                        <option value="" hidden></option>
                                    </select>
                                    <label style="font-size: larger;" for="car_engine">Car Engine</label>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                    @error('car_engine')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div style="text-align: center; margin-top: 20px; height: 60px;">
                                    <button type="submit" class="button button-find">+ ADD CAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="text-black card-body" style="width: 40%;">
                        <div style="padding-top: 55px;">
                            <div style="">
                                <span style="font-weight: 700; padding-left: 40px;">Car List:</span>
                            </div>
                            <div style="width: 80%; margin: auto;" class="overflow-car">
                                @foreach ($car_list as $c)
                                    <form action="{{ route('user.updateCar', ['id' => $c->id]) }}" method="POST" style="">
                                        @csrf
                                        <button class="list-mobil" type="submit" style="margin-bottom: 10px; padding: 8px; position: relative;">
                                            <div style="position: absolute; padding-left: 5px; padding-top: 2px;">
                                                <a href="" onclick="delete_button({{ $c->id }})"><img src="{{ asset('img/Logo/delete.png') }}" alt="" style="width: 15px;"></a>
                                            </div>
                                            <div class="" style="width: 100%; text-align: center;">
                                            <img style="margin: auto;" src="{{ asset('img/Logo/image2.png') }}" alt="">
                                            {{-- <img style="width: 45px;" src="{{ route('brand.image', ['imageName' => $c->car_brand_logo]) }}" /> --}}
                                            </div>
                                            <div>
                                                <span>{{ $c->car_year }}</span>
                                                <span>{{ $c->car_model_name }}</span>
                                                <span>{{ $c->car_engine_name }}</span>
                                            </div>
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('content_profile_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .overflow-car {
        height: 330px !important;
        overflow-y: scroll; /* Hanya scroll secara vertikal */
        overflow-x: hidden; /* Sembunyikan scroll horizontal */
    }

    /* Sembunyikan scrollbar untuk browser WebKit (Chrome, Safari) */
    .overflow-car::-webkit-scrollbar {
        display: none;
    }

    /* Sembunyikan scrollbar untuk Firefox */
    .overflow-car {
        scrollbar-width: none; /* Firefox */
    }

    /* Sembunyikan scrollbar untuk Internet Explorer dan Edge */
    .overflow-car {
        -ms-overflow-style: none;  /* IE and Edge */
    }

        .list-mobil{
            text-align: center;
            background: white;
            box-shadow: -1px 2px 4px rgba(0, 0, 0, 0.25);
            border-radius: 5px;
            border: 1px black solid;
        }

        .addCarModal{
            padding: 1px 20px 1px 20px;
        }

        .add-new-car{
            font-weight: 700;
            font-size: 3rem;
        }
    </style>
@endpush
@push('content_profile_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function delete_button(id) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure want to delete this car ?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#F36600',
            }).then((result) => {
                if (result.isConfirmed) {
                    // var form = document.getElementById("rejectForm" + id);
                    // form.submit();
                    window.location.href = '/user/delete/car/' + id;
                }
            });
        }
    </script>
@endpush
