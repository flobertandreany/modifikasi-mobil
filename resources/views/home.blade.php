@extends('layouts.main')

@section('content')
    <div class="">
        <div style="display: flex; justify-content: space-between; width:50%;">
            <div class="container">

                <div class="p-4 p-lg-5 text-black card-body">
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
                                <select name="car_year" id="car_year" class="form-control" required>
                                    <option value="" hidden></option>
                                    @foreach($year as $y)
                                        <option value="{{ $y->car_year }}">{{ $y->car_year }}</option>
                                    @endforeach
                                </select>
                                <label style="font-size: larger;" for="car_year" >Car Year</label>
                                <i class="fas fa-chevron-down select-icon"></i>
                            </div>
                            <div class="form-outline mb-2 form-floating">
                                <select name="car_brand" id="car_brand" class="form-control" required>
                                    <option value="" hidden></option>
                                </select>
                                <label style="font-size: larger;" for="car_brand">Car Brand</label>
                                <i class="fas fa-chevron-down select-icon"></i>
                            </div>
                            <div class="form-outline mb-2 form-floating">
                                <select name="car_model" id="car_model" class="form-control" required>
                                    <option value=""hidden ></option>
                                </select>
                                <label style="font-size: larger;" for="car_model">Car Model</label>
                                <i class="fas fa-chevron-down select-icon"></i>
                            </div>
                            <div class="form-outline mb-2 form-floating">
                                <select name="car_engine" id="car_engine" class="form-control" required>
                                    <option value="" hidden></option>
                                </select>
                                <label style="font-size: larger;" for="car_engine">Car Engine</label>
                                <i class="fas fa-chevron-down select-icon"></i>
                            </div>
                            <div style="text-align: center; margin-top: 20px; height: 60px;">
                                <button type="submit" class="button button-find">FIND NOW!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">

        </div>
    </div>

@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

        .button-find{
            background: #0A76DB;
            box-shadow: 0px 3px 3px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
            overflow: hidden;
            border: 1px white solid;
            width: 130px;
            color: white;
            height: 90%;
        }

        .form-outline{
            box-shadow: 0px 3px 3px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
            margin-bottom: 1.5rem !important;
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
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $('#car_year').change(function(){
            var year_id = $(this).val();

            //reset options
            $('#car_brand').empty().append('<option value="" hidden></option>');
            $('#car_model').empty().append('<option value="" hidden></option>');
            $('#car_engine').empty().append('<option value="" hidden></option>');

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
                        $('#car_brand').append('<option value="' + brand.id + '">' + brand.car_brand_name + '</option>');

                    });
                    }
                });
            }
        });

        $('#car_brand').change(function(){
            var brand_id = $(this).val();
            console.log(brand_id);
            //reset options
            $('#car_model').empty().append('<option value="" hidden></option>');
            $('#car_engine').empty().append('<option value="" hidden></option>');

            if(brand_id){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                    },
                    url: "/user/model",
                    method: "GET",
                    dataType: "json",
                    data: {
                        brand_id: brand_id,
                        car_year: $('#car_year').val(),
                    },
                    success: function(data){
                        data.forEach(function(model) {
                        $('#car_model').append('<option value="' + model.id + '">' + model.car_model_name + '</option>');
                    });
                    }
                });
            }
        });

        $('#car_model').change(function(){
            var model_id = $(this).val();
            console.log(model_id);
            //reset options
            $('#car_engine').empty().append('<option value="" hidden></option>');

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
                        $('#car_engine').append('<option value="' + engine.id + '">' + engine.engine_name + '</option>');
                    });
                    }
                });
            }
        });
    </script>
@endpush
