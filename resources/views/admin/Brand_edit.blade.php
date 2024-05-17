@extends('layouts.main')

@section('content')
    <h1 style="color: white; margin-bottom: 30px; padding-left:25px;">{{ $title }}</h1>

    <div class="container" style="">
        <form action="{{ route('brand.update', ['id' => $brand->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
                <div class="divBorder divBrandName">
                    <label for="car_brand_name" class="form-label">Car Brand Name</label>
                    <input type="text" class="inputName form-control @error('car_brand_name') is-invalid @enderror" id="car_brand_name" name="car_brand_name" value="{{ $brand->car_brand_name }}">
                    @error('car_brand_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="col-md-12" style="text-align: right; padding-top:10px;">
                        <button type="submit" class="sub btn" style="background-color: #f3b200;">Update</button>
                    </div>
                </div>

                <div class="" style="color: white;">
                    <label for="brand_name" class="form-label">Upload Brand Logo</label>
                    <div class="div_carLogo container-fluid @error('car_brand_logo') is-invalid @enderror" style="" width="285" height="245">
                        @if ($brand->car_brand_logo)
                            <img id="output" src="{{ asset('img/brand/' . $brand->car_brand_logo) }}" class="img_logo rounded" alt="Image Profile" width="295" height="245">
                        @else
                        <img id="output" src="{{ asset('img/Logo/image.png') }}" class="img_logo rounded" alt="Image Profile" width="295" height="245" onerror="this.onerror=null;this.src='{{ asset('img/Logo/carLogo.png') }}';">
                        @endif
                    </div>
                    @error('car_brand_logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div style="text-align: center; margin-top: 10px;">
                        <label for="car_brand_logo" class="btn" style="background-color: #F36600; color:white;">
                            Choose Logo
                            <input type="file" id="car_brand_logo" name="car_brand_logo" onchange="previewImage(event)" style="display: none;" accept="image/jpeg, image/png, image/jpg">
                        </label>
                    </div>
                </div>
            </div>

        </form>
    </div>
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .divBrandName{
            padding: 50px 60px 60px 60px;
            color: white;
        }

        .inputName{
            border-color: black;
            width:600px;
        }

        .div_carLogo{
            border: 2px solid #F36600;
            padding-left:0;
            padding-right:0;
            border-radius:10px;
            background-color: rgb(97, 97, 97);
        }

        .img_logo{
            width: 295px;
            height: 245px;
            /* padding: 40px 60px 40px 60px; */
        }

        .sub{
            border-radius: 100px;
            width: 100px;
            font-size: 13px;
            font-weight: bold;
            border: 2px solid #F36600;
            margin-top: 20px;
        }
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var img = document.getElementById('output');
                img.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // function validateForm() {
        // var brandName = document.getElementById("car_brand_name").value;
        // var retypeBrandName = document.getElementById("r-type_brand_name").value;

        // if (brandName !== retypeBrandName) {
        //     alert("Brand Name dan Re-type Car Brand Name harus sama.");
        //     return false;
        // }
        // return true;
        // }
    </script>
@endpush
@endsection
