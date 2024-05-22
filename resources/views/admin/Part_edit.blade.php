@extends('layouts.main')

@section('content')
    <h1 style="color: white; margin-bottom: 30px;">{{ $title }}</h1>

    <div class="container" style="">
        <form action="{{ route('part.update', ['id' => $part->id]) }}" method="POST">
            @csrf
            <div class="divBorder container">
                <div class="row g-3" style="padding: 50px 20px 50px 20px; color:white;">
                    <div class="col-md-5 custom-column">
                        <label for="part_type" class="form-label">Part Type</label>
                        <select class="formModel form-select @error('part_type') is-invalid @enderror" id="part_type" name="part_type" required>
                            <option value="" disabled {{ old('car_brand', $part->product_category_id ?? '') ? '' : 'selected' }}>Choose Part Type</option>
                            <option value="1" {{ old('part_type', $part->product_category_id ?? '') == 1 ? 'selected' : '' }}>Spare Parts</option>
                            <option value="2" {{ old('part_type', $part->product_category_id ?? '') == 2 ? 'selected' : '' }}>Modification</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="product_name" class="form-label">Part Name</label>
                        <input type="text" class="formModel form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{ $part->product_name }}" id="product_name">
                        @error('product_name')
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
