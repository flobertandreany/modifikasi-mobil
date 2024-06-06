@extends('layouts.main')

@section('content')
    <div style="min-height: 140rem;">
        <div style="width:50%; padding-top: 10px; padding-left: 70px;">
            <div class="container">
                <div class="p-lg-5 text-black card-body">
                    <form action="{{ route('user.addUserCar') }}" method="POST">
                        @csrf
                        <div class="d-flex align-items-center justify-content-center pb-1">
                            <span class="find-now">FIND NOW!</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-3 pb-1">
                            <h2 class="choose-vehicle">Choose Your Vehicle Here!</h2>
                        </div>
                        <div class="register-store overflow-auto">
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
                                <button type="submit" class="button button-find">FIND NOW!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container" style="padding-top: 100px;">
            <div class="text-black card-body">
                <div class="d-flex align-items-center pb-1">
                    <span class="popular-modification">POPULAR FOR MODIFICATIONS</span>
                </div>
                <div>
                    <div class="row g-3" style="justify-content: space-evenly;">
                        @foreach ($mod as $m)
                        <a class="col-md-3 card-button" href="{{ route('user.productDetail', ['type' => $m->type, 'name' => $m->product_name, 'id' => $m->id ]) }}">
                            <div class="card car-mod">
                                <div class="card-header header-recomend ">
                                    <img src="{{ route('store.productImage', ['imageName' => $m->mod_image]) }}" class="card-img-top" style="max-width: 140px; margin: 10px 40px 10px 40px;" alt="...">
                                </div>
                                <div class="card-body card-body-recomend">
                                    <div class="judul-mod">
                                        {{ $m->mod_name }}
                                    </div>
                                    <h5 class="price">Rp. {{ number_format($m->mod_price, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex align-items-center pb-1" style="padding-top: 65px;">
                    <span class="popular-modification">POPULAR FOR SPARE PARTS</span>
                </div>
                <div style="padding-bottom: 50px;">
                    <div class="row g-3" style="justify-content: space-evenly;">
                        @foreach ($sparepart as $s)
                        <a class="col-md-3 card-button" href="{{ route('user.productDetail', ['type' => $s->type, 'name' => $s->product_name, 'id' => $s->id ]) }}">
                            <div class="card car-mod">
                                <div class="card-header header-recomend" style="background-color: white; text-align: center;">
                                    <img src="{{ route('store.productImage', ['imageName' => $s->sparepart_image]) }}" class="card-img-top" style="max-width: 140px; margin: 10px 40px 10px 40px;" alt="...">
                                </div>
                                <div class="card-body card-body-recomend">
                                    <div class="judul-mod">
                                        {{ $s->sparepart_name }}
                                    </div>
                                    <h5 class="price">Rp. {{ number_format($s->sparepart_price, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .card-button{
            height: 300px;
            width: 290px;
            text-decoration: none;
            color: inherit;
        }

        .card-button:hover{
            text-decoration: none;
            color: inherit;
        }
        .car-details{
            width: 130px;
            height: 42px;
            left: 60px;
            top: 6px;
            position: absolute;
            color: white;
            font-size: 10px;
            font-family: Montserrat;
            font-weight: 500;
            line-height: 14px;
            letter-spacing: 0.50px;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-button:active{
            text-decoration: none;
            color: inherit;
        }

        .card-button:hover .judul-mod{
            color: inherit;
        }

        .form-outline{
            box-shadow: 0px 3px 3px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
            margin-bottom: 1.5rem !important;
        }

        .popular-modification{
            font-weight: 1000;
            font-size: 2rem;
            color: white;
            padding-left: 37px;
            padding-bottom: 15px;
        }

        .find-now{
            font-weight: 1000;
            font-size: 3.5rem;
            letter-spacing: 3px;
        }

        .register-store{
            padding: 1px 100px 1px 100px;
        }

        /* .image-background {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image: url('{{ asset('img/Logo/Gambar Mobil.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
            opacity: 0.3;
        } */

        .div-image-mobil{
            /* background-image: url('../img/Logo/Gambar Mobil.png');
            background-size: cover; */
            display: flex;
            justify-content: center;
            /* padding-top: 250px; */
        }

        .choose-vehicle{
            font-weight: 400;
            font-size: 1.5rem;
        }

        .fixed-image {
            /* position: absolute; */
            /* top: 60%;
            left: 75%;
            transform: translate(-50%, -50%); */
            width: 600px; /* Adjust width as needed */
            height: auto; /* Maintain aspect ratio */
        }
    </style>
@endpush
@push('content_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if(session('error'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Failed',
                    text: 'engine already added.',
                    confirmButtonColor: '#19B400',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'confirm-button-swal'
                    }
                });
            @endif
        });

        $('.car-year-select').change(function(){
            var year_id = $(this).val();
            var form = $(this).closest('form');

            //reset options
            form.find('.car-brand-select').empty().append('<option value="" hidden></option>');
            form.find('.car-model-select').empty().append('<option value="" hidden></option>');
            form.find('.car-engine-select').empty().append('<option value="" hidden></option>');

            if(year_id){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                    },
                    url: "/user/brand",
                    method: "GET",
                    dataType: "json",
                    data: {
                        car_year: year_id,
                    },
                    success: function(data){
                        data.forEach(function(brand) {
                            form.find('.car-brand-select').append('<option value="' + brand.id + '">' + brand.car_brand_name + '</option>');

                    });
                    }
                });
            }
        });

        $('.car-brand-select').change(function(){
            var brand_id = $(this).val();
            var form = $(this).closest('form');
            var car_year = form.find('.car-year-select').val();

            console.log(brand_id);
            //reset options
            form.find('.car-model-select').empty().append('<option value="" hidden></option>');
            form.find('.car-engine-select').empty().append('<option value="" hidden></option>');

            if(brand_id){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                    },
                    url: "/user/model",
                    method: "GET",
                    dataType: "json",
                    data: {
                        car_year: car_year,
                        brand_id: brand_id,
                    },
                    success: function(data){
                        data.forEach(function(model) {
                            $('.car-model-select').append('<option value="' + model.id + '">' + model.car_model_name + '</option>');
                    });
                    }
                });
            }
        });

        $('.car-model-select').change(function(){
            var model_id = $(this).val();
            var form = $(this).closest('form');

            console.log(model_id);
            //reset options
            $('.car-engine-select').empty().append('<option value="" hidden></option>');

            if(model_id){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                    },
                    url: "/user/engine",
                    method: "GET",
                    dataType: "json",
                    data: {
                        model_id: model_id,
                    },
                    success: function(data){
                        data.forEach(function(engine) {
                            $('.car-engine-select').append('<option value="' + engine.id + '">' + engine.engine_name + '</option>');
                    });
                    }
                });
            }
        });
    </script>
@endpush
