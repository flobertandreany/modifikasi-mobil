@extends('layouts.main')

@section('content')
    <div class="d-flex">
        <a href="{{ route('car.engine.list') }}" class="btn-back"><i class="fa fa-arrow-left fa-2x"></i></a>
        <h1 style="color: white; margin-bottom: 30px; margin-left: 1rem;">{{ $title }}</h1>
    </div>
    <div class="container" style="">
        <form action="{{ route('engine.update', ['id' => $engine->id]) }}" method="POST">
            @csrf
            <div class="divBorder container">
                <div class="profile-form" style="padding: 50px 250px 450px 250px; background-color: rgb(83, 83, 83); color:white;">
                    <div class="col-md-12">
                        <div class="field-form">
                            <label for="car_year" class="form-label">Car Year</label>
                            <input type="text" class="formModel form-control" name="car_year" id="car_year" disabled value="{{ $model->car_year }}" style="background-color: gray;">
                        </div>
                        <div class="field-form">
                            <label for="car_brand" class="form-label">Car Brand</label>
                            <input type="text" class="formModel form-control" name="car_brand" id="car_brand" disabled value="{{ $brand->car_brand_name }}" style="background-color: gray;">
                        </div>
                        <div class="field-form">
                            <label for="car_model" class="form-label">Car Model</label>
                            <input type="text" class="formModel form-control" name="car_model" id="car_model" disabled value="{{ $model->car_model_name }}" style="background-color: gray;">
                        </div>
                        <div class="field-form">
                            <label for="engine_name" class="form-label">Engine Name</label>
                            <input type="text" class="formModel form-control @error('engine_name') is-invalid @enderror" name="engine_name" id="engine_name" value="{{ $engine->engine_name }}">
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

    </script>
@endpush
@endsection
