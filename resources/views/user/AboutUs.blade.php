@extends('layouts.main')

@section('content')
    <div class="term-condition-container" style="background: #000000;">
        <div class="container">
            <div>
                <div class="gambar-atas">
                    <div>
                        <img style="width: 100%" src="{{ asset('img/Logo/aboutus.png') }}" alt="">
                    </div>
                </div>
                <div style="text-align: justify; color: rgb(197, 197, 197); padding-top: 50px;">
                    Sparecar is a Website that give you information about spare-parts. You could find specific parts just witch filling your car types etc. Mobil 1™ Advanced Fuel Economy 0W-20 is a specialized engine oil produced by ExxonMobil, designed to provide maximum engine protection while enhancing fuel efficiency. With a viscosity grade of 0W-20, the oil ensures low-temperature fluidity for improved cold start performance and engine longevity. Branded as "Advanced Fuel Economy," it is formulated to reduce internal friction within the engine, contributing to enhanced fuel efficiency. Mobil 1™ Advanced Fuel Economy 0W-20 is a specialized engine oil produced by ExxonMobil, designed to provide maximum engine protection while enhancing fuel efficiency. With a viscosity grade of 0W-20, the oil ensures low-temperature fluidity for improved cold start performance and engine longevity. Branded as "Advanced Fuel Economy," it is formulated to reduce internal friction within the engine, contributing to enhanced fuel efficiency.
                </div>
                <div class="gambar-bawah">
                    <div style="padding-right: 50px;">
                        <img style="width: 460px;" src="{{ asset('img/Logo/gambar-bawah-aboutus.png') }}" alt="">
                    </div>
                    <div>
                        <h1 style="color: white;">
                            FIND YOUR RECOMMENDED
                        </h1>
                        <h1 style="color: white;">
                            SPAREPARTS!
                        </h1>
                        <p style="text-align: justify; color: rgb(197, 197, 197);">
                            Mobil 1™ Advanced Fuel Economy 0W-20 is a specialized engine oil produced by ExxonMobil, designed to provide maximum engine protection while enhancing fuel efficiency. With a viscosity grade of 0W-20, the oil ensures low-temperature fluidity for improved cold start performance and engine longevity. Branded as "Advanced Fuel Economy," it is formulated to reduce internal friction within the engine, contributing to enhanced fuel efficiency.
                        </p>
                    </div>
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
        .gambar-atas{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }
        .gambar-bawah{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>

    </script>
@endpush
