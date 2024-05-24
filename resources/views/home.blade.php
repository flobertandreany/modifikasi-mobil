@extends('layouts.main')

@section('content')
    <div style="display: flex; justify-content: space-between; padding-top: 50px;">
        {{-- <div style="flex: 1; text-align: center;">
            <h1 class="find-now">FIND NOW!</h1>
            <h2 class="choose-vehicle">Choose Your Vehicle Here!</h2>
            <form action="">
                <input type="text" name="search" id="search" placeholder="Search" style="width: 300px; height: 30px; border-radius: 10px;">
                <input type="submit" value="Search" style="width: 100px; height: 30px; border-radius: 10px; background-color: #000000; color: white;">
            </form>
        </div> --}}
        <div class="p-4 p-lg-5 text-black card-body">
            <form action="" method="POST">
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
                            <option value="">Select Car Year</option>
                            @foreach($year as $y)
                                <option value="{{ $y->car_year }}">{{ $y->car_year }}</option>
                            @endforeach
                        </select>
                        <label for="car_year">Car Year</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="form-outline mb-2 form-floating">
                        <select name="car_brand" id="car_brand" class="form-control" required>
                            <option value="">Select Car Brand</option>
                        </select>
                        <label for="car_brand">Car Brand</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="form-outline mb-2 form-floating">
                        <select name="car_model" id="car_model" class="form-control" required>
                            <option value="">Select Car Model</option>
                        </select>
                        <label for="car_model">Car Model</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <div class="form-outline mb-2 form-floating">
                        <select name="car_engine" id="car_engine" class="form-control" required>
                            <option value="">Select Car Engine</option>
                        </select>
                        <label for="car_engine">Car Engine</label>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <div class="div-image-mobil">
                <img src="{{ asset('img/Logo/Gambar Mobil.png') }}" alt="car" class="fixed-image">
            </div>
        </div>
    </div>

@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .find-now{
            font-weight: 1000;
            font-size: 3.5rem;
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
            $('#car_brand').empty().append('<option value="">Select Car Brand</option>');
            $('#car_model').empty().append('<option value="">Select Car Model</option>');
            $('#car_engine').empty().append('<option value="">Select Car Engine</option>');

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
            $('#car_model').empty().append('<option value="">Select Car Model</option>');
            $('#car_engine').empty().append('<option value="">Select Car Engine</option>');

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
            $('#car_engine').empty().append('<option value="">Select Car Engine</option>');

            if(model_id){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                    },
                    url: "/admin/engine",
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
