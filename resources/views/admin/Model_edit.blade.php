@extends('layouts.main')

@section('content')
    <div class="d-flex">
        <a href="{{ route('car.model.list') }}" class="btn-back"><i class="fa fa-arrow-left fa-2x"></i></a>
        <h1 style="color: white; margin-bottom: 30px; margin-left: 1rem;">{{ $title }}</h1>
    </div>
    <div class="container" style="">
        <form action="{{ route('model.update', ['id' => $model->id]) }}" method="POST">
            @csrf
            <div class="divBorder container">
                <div class="profile-form" style="padding: 50px 250px 50px 250px; background-color: rgb(83, 83, 83); color:white;">
                    <div class="col-md-12">
                        <div class="field-form">
                            <label for="car_brand" class="form-label">Car Brand</label>
                            <input type="text" class="formModel form-control @error('car_brand') is-invalid @enderror" name="car_brand" value="{{ $brand->car_brand_name }}" id="car_brand" disabled style="background-color: gray;">
                        </div>
                        <div class="field-form">
                            <label for="car_model_name" class="form-label">Car Model Name</label>
                            <input type="text" class="formModel form-control @error('car_model_name') is-invalid @enderror" name="car_model_name" value="{{ $model->car_model_name }}" id="car_model_name">
                            @error('car_model_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="field-form">
                            <label for="car_year" class="form-label">Car Year</label>
                            <input type="text" class="formModel form-control @error('car_year') is-invalid @enderror" name="car_year" id="car_year" value="{{ $model->car_year }}" >
                            @error('car_year')
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
