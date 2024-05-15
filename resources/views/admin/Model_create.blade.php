@extends('layouts.main')

@section('content')
    <h1 style="color: white; margin-bottom: 30px;">{{ $title }}</h1>

    <div class="container" style="">
        <form action="{{ route('model.create') }}" method="POST">
            @csrf
            <div class="divBorder container">
                <div class="row g-3" style="padding: 50px 20px 50px 20px; color:white;">
                    <div class="col-md-5 custom-column">
                        <label for="car_brand" class="form-label">Car Brand</label>
                        <select class="formModel form-control" id="car_brand" name="car_brand" value="{{ old('car_brand') }}" required>
                            <option selected value="">Choose Car Brand</option>
                            @foreach ($brand as $b)
                                <option value="{{ $b->id }}">{{ $b->car_brand_name }}</option>
                            @endforeach
                        </select>
                        {{-- <label for="car_brand">Car Brand</label>
                        <select name="car_brand" id="car_brand" class="form-control" required value="{{ old('car_brand') }}">
                            <option value="">Select Car Brand</option>
                            @foreach($brand as $b)
                                <option value="{{ $b->id }}">{{ $b->car_brand_name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i> --}}
                    </div>
                    <div class="col-md-5">
                        <label for="car_model_name" class="form-label">Car Model Name</label>
                        <input type="text" class="formModel form-control @error('car_model_name') is-invalid @enderror" name="car_model_name" value="{{ old('car_model_name') }}" id="car_model_name">
                        @error('car_model_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5 custom-column">
                        <label for="car_year" class="form-label">Car Year</label>
                        <input type="text" class="formModel form-control @error('car_year') is-invalid @enderror" name="car_year" id="car_year" value="{{ old('car_year') }}" >
                        @error('car_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label for="engine_name" class="form-label">Engine Type</label>
                        <input type="text" class="formModel form-control @error('engine_name') is-invalid @enderror" name="engine_name" id="engine_name" value="{{ old('engine_name') }}">
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

        .divBorder{
            background-color: rgb(83, 83, 83);
            border-radius: 5px;
            border: 2px solid rgb(214, 214, 214);
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
