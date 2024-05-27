@extends('layouts.main')

@section('content')
    <div class="d-flex">
        <a href="{{ route('car.engine.list') }}" class="btn-back"><i class="fa fa-arrow-left fa-2x"></i></a>
        <h1 style="color: white; margin-bottom: 30px; margin-left: 1rem;">{{ $title }}</h1>
    </div>
    <div class="container" style="">
        <form action="{{ route('engine.create') }}" method="POST">
            @csrf
            <div class="divBorder container">
                <div class="profile-form" style="padding: 50px 250px 450px 250px; background-color: rgb(83, 83, 83); color:white;">
                    <div class="col-md-12">
                        <div class="field-form">
                            <label for="car_year" class="form-label">Car Year</label>
                            <select class="formModel form-select @error('car_year') is-invalid @enderror" id="car_year" name="car_year" required>
                                <option value="">Choose Car Year</option>
                                @foreach ($year as $b)
                                    <option value="{{ $b->car_year }}">{{ $b->car_year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-form">
                            <label for="car_brand" class="form-label">Car Brand</label>
                            <select class="formModel form-select @error('car_brand') is-invalid @enderror" id="car_brand" name="car_brand" required>
                                <option value="">Choose Car Brand</option>
                            </select>
                        </div>
                        <div class="field-form">
                            <label for="car_model" class="form-label">Car Model</label>
                            <select class="formModel form-select @error('car_model') is-invalid @enderror" id="car_model" name="car_model" required>
                                <option value="">Choose Car Model</option>
                            </select>
                        </div>
                        <div class="field-form">
                            <label for="engine_name" class="form-label">Engine Name</label>
                            <input type="text" class="formModel form-control @error('engine_name') is-invalid @enderror" name="engine_name" id="engine_name" >
                            @error('engine_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12" style="text-align: center;">
                            <input type="submit" class="buttonSubmit btn" style="background-color: #f3b200;">
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

        .formModel{
            border: 1px solid black;
        }

        .custom-column {
            margin-right: 100px;
            margin-left: 45px;
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
    </script>
@endpush
@endsection
