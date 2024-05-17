@extends('layouts.main')

@section('content')
    <h1 style="color: white; margin-bottom: 30px;">{{ $title }}</h1>

    <div class="container" style="">
        <form action="{{ route('model.update', ['id' => $model->id]) }}" method="POST">
            @csrf
            <div class="divBorder container">
                <div class="row g-3" style="padding: 50px 20px 50px 20px; color:white;">
                    <div class="col-md-5 custom-column">
                        <label for="car_brand" class="form-label">Car Brand</label>
                        <select class="formModel form-select @error('car_brand') is-invalid @enderror" id="car_brand" name="car_brand" required>
                            <option value="" disabled {{ old('car_brand', $model->car_brand_id ?? '') ? '' : 'selected' }}>Choose Car Brand</option>
                            @foreach ($brand as $b)
                                <option value="{{ $b->id }}" {{ old('car_brand', $model->car_brand_id ?? '') == $b->id ? 'selected' : '' }}>{{ $b->car_brand_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="car_model_name" class="form-label">Car Model Name</label>
                        <input type="text" class="formModel form-control @error('car_model_name') is-invalid @enderror" name="car_model_name" value="{{ $model->car_model_name }}" id="car_model_name">
                        @error('car_model_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5 custom-column">
                        <label for="car_year" class="form-label">Car Year</label>
                        <input type="text" class="formModel form-control @error('car_year') is-invalid @enderror" name="car_year" id="car_year" value="{{ $model->car_year }}" >
                        @error('car_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label for="engine_name" class="form-label">Engine Type</label>
                        <input type="text" class="formModel form-control @error('engine_name') is-invalid @enderror" name="engine_name" id="engine_name" value="{{ $engine->engine_name }}">
                        @error('engine_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12" style="text-align: center; margin-top: 50px;">
                        <input type="submit" class="buttonSubmit btn" style="background-color: #f3b200;">
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
