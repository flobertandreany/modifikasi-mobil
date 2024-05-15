@extends('layouts.main')

@section('content')
    <h1 style="color: white; margin-bottom: 30px;">{{ $title }}</h1>

    <div class="container" style="">
        <form action="{{ route('brand.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container" style="display: flex; justify-content: space-between; gap: 100px; align-items: center;">
                <div class="row g-1" style="background-color: grey; padding: 20px 30px 30px 30px; border-radius: 5px; color: white;">
                    <label for="car_brand_name" class="form-label">Brand Name</label>
                    <input type="text" class="form-control" id="car_brand_name" name="car_brand_name" style="border-color: black; margin-bottom: 10px;" required>

                    <label for="r-type_brand_name" class="form-label">Re-type Car Brand Name</label>
                    <input type="text" class="form-control" id="r-type_brand_name" name="r-type_brand_name" required>
                    <div class="col-md-12" style="text-align: right; padding-top:10px;">
                        <input type="submit" class="btn text-light" style="background-color: #F36600;">
                    </div>
                </div>

                <div class="" style="color: white;">
                    <label for="brand_name" class="form-label">Upload Brand Logo</label>
                    <div class="container-fluid" style="text-align: center; background-color: #363636; height: 250px; width: 300px; border-radius: 5px; border: 2px solid orange">
                        <img id="output" src="{{ asset('img/login/Logo SpareCar.png') }}" class="rounded mb-3" alt="Image Profile" width="285" height="245" onerror="this.onerror=null;this.src='{{ asset('img/login/profile.jpg') }}';">
                    </div>
                    <div style="text-align: center; margin-top: 10px;">
                        <label for="car_brand_logo" class="btn btn-primary">
                            Choose Logo
                            <input type="file" id="car_brand_logo" name="car_brand_logo" onchange="previewImage(event)" style="display: none;">
                        </label>
                    </div>
                </div>
            </div>

        </form>
    </div>

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

@endsection
