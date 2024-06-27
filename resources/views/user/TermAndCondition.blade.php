@extends('layouts.main')

@section('content')
    <div class="term-condition-container" style="background: #171716;">
        <div class="header-image" style="margin-bottom: 2rem;">
            <h1>{{ $title }}</h1>
        </div>
        <div class="container" style="height: 37rem;">
            <div class="introduction" style="padding-top: 20px;">
                <h1 style="padding-bottom: 20px; color: white;">INTRODUCTION</h1>
                <p style="color: rgb(197, 197, 197);">The guidelines for using SpareCar.ID, the website of SpareCar, are set forth in these terms and conditions. We presume that by using this website, you agree to these terms and conditions. If you do not accept all of the terms and conditions listed on this page, stop using SpareCar. </p>
            </div>
            <div class="contentnya">
                <div class="cookies" style="width: 900px; padding-right: 50px;">
                    <h1 style="padding-bottom: 20px; color: white;">COOKIES</h1>
                    <p style="color: rgb(197, 197, 197); text-align: justify !important;">We use cookies in our operations. You accepted to use cookies in accordance with SpareCar's privacy policy by using SpareCar. Cookies are used by most interactive websites to enable us to retrieve user information each time a user visits. Our website uses cookies to make some sections functional and to make it easier for users to navigate. Cookies may also be used by a few of our affiliates and advertising partners.</p>
                </div>
                <div class="license" style="padding-right: 50px;">
                    <h1 style="padding-bottom: 20px; color: white;">LICENSE</h1>
                    <div>
                        <p style="color: rgb(197, 197, 197); text-align: justify !important;">All content on SpareCar, unless otherwise indicated, is the intellectual property of [Company Name] and/or its licensors. Every right to intellectual property is reserved. The limitations outlined in these terms and conditions apply to your personal use of this, which you may access from SpareCar.</p>
                    </div>
                    <div style="color: rgb(197, 197, 197);">
                        You ought not to:
                        <li>
                            Copy and distribute content from SpareCar
                        </li>
                        <li>
                            You may sublicense, rent, or sell content from SpareCar.
                        </li>
                        <li>
                            Duplicate, reproduce, or copy content from SpareCar
                        </li>
                        <li>
                            Reshare content from SpareCar
                        </li>
                    </div>

                </div>
                <div class="gambar">
                    <img style="width: 250px;" src="{{ asset('img/Logo/imgterm.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .term-condition-container {
            padding-top: 3.5rem;
            padding-bottom: 100px;
        }
        .header-image {
            position: relative; /* Penting untuk pseudo-element positioning */
            background-image: url('../img/Logo/termandcondition.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header-image::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.45);
        }
        .header-image h1 {
            position: relative;
            color: white;
            font-weight: bold;
            font-size: 58px;
        }
        .contentnya{
            display: flex;
            justify-content: center;
            padding-top: 45px;
        }
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>

    </script>
@endpush
