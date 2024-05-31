@extends('layouts.main')

@section('content')
    <div class="product-detail-container" style="background: black;">
        <div class="container" style="height: 125rem;">
            <section class="py-5">
                <div class="container">
                  <div class="row gx-5">
                    <aside class="col-lg-6">
                        <div class="border rounded-4 mb-3 d-flex justify-content-center">
                            @if($products->image)
                                <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="{{ route('user.store.productImage', ['imageName' => $products->image]) }}" alt="Image Product">
                            @else
                                <img class="img-product-table" src="{{ asset('img/logo/LogoParts.jpg') }}" alt="Image Product" onerror="this.onerror=null;this.src='{{ asset('img/logo/LogoParts.jpg') }}';" style="width: 100%; height: auto;">
                            @endif
                        </div>
                    </aside>
                    <main class="col-lg-6 rounded-3" style="background: dimgray;">
                        <div class="ps-lg-3">
                            <h2 class="title text-white fw-bold">
                                {{ $products->name }}
                            </h2>
                            <div class="d-flex flex-row my-3">
                                <div class="text-white mb-1 me-2">
                                    <h4 class="mb-1 me-1">Rp. {{ number_format($products->price, 0, ',', '.') }}</h4>
                                </div>
                                <button class="btn btn-filter rounded-3 d-flex justify-content-between" type="button" style="background-color: #F36600;">
                                    <a class="text-decoration-none" target="_blank" href="{{ route('home') }}">
                                        <span class="text-white">Buy In Shopee</span>
                                    </a>
                                </button>
                                <button class="btn btn-filter rounded-3 d-flex justify-content-between" type="button" style="background-color: #00621C;">
                                    <a class="text-decoration-none" target="_blank" href="{{ route('home') }}">
                                        <span class="text-white">Buy In Tokopedia</span>
                                    </a>
                                </button>
                            </div>
                            <h3 class="text-white">Product Descriptions</h3>

                            <p class="text-white mb-4 mb-md-0">
                                {{ $products->description }}
                            </p>

                            <hr/>
                        </div>
                    </main>
                  </div>
                </div>
            </section>
            <div class="container">
                <header class="mb-4">
                    <h3 class="text-white">Product Specs</h3>
                </header>
                <div class="col-lg-12 mb-4">
                    <table class="table border mt-3 mb-2 text-white">
                        <tr>
                            <th class="py-6">Display:</th>
                            <td class="py-6">13.3-inch LED-backlit display with IPS</td>
                        </tr>
                        <tr>
                            <th class="py-2">Processor capacity:</th>
                            <td class="py-2">2.3GHz dual-core Intel Core i5</td>
                        </tr>
                        <tr>
                            <th class="py-2">Camera quality:</th>
                            <td class="py-2">720p FaceTime HD camera</td>
                        </tr>
                        <tr>
                            <th class="py-2">Memory</th>
                            <td class="py-2">8 GB RAM or 16 GB RAM</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="container my-5">
            <header class="mb-4">
                <h3 class="text-white">Recommended For Your Car</h3>
            </header>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card px-4 border shadow-0 mb-4 mb-lg-0">
                    <a href="#" class="">
                    <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/7.webp" class="card-img-top rounded-2" />
                    </a>
                    <div class="card-body d-flex flex-column pt-3 border-top">
                    <a href="#" class="nav-link">Gaming Headset with Mic</a>
                    <div class="price-wrap mb-2">
                        <strong class="">$18.95</strong>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card px-4 border shadow-0 mb-4 mb-lg-0">
                    <a href="#" class="">
                    <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/5.webp" class="card-img-top rounded-2" />
                    </a>
                    <div class="card-body d-flex flex-column pt-3 border-top">
                    <a href="#" class="nav-link">Apple Watch Series 1 Sport </a>
                    <div class="price-wrap mb-2">
                        <strong class="">$120.00</strong>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card px-4 border shadow-0">
                    <a href="#" class="">
                    <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/9.webp" class="card-img-top rounded-2" />
                    </a>
                    <div class="card-body d-flex flex-column pt-3 border-top">
                    <a href="#" class="nav-link">Men's Denim Jeans Shorts</a>
                    <div class="price-wrap mb-2">
                        <strong class="">$80.50</strong>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card px-4 border shadow-0">
                    <a href="#" class="">
                    <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/10.webp" class="card-img-top rounded-2" />
                    </a>
                    <div class="card-body d-flex flex-column pt-3 border-top">
                    <a href="#" class="nav-link">Mens T-shirt Cotton Base Layer Slim fit </a>
                    <div class="price-wrap mb-2">
                        <strong class="">$13.90</strong>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .product-detail-container {
            padding-top: 6rem;
            padding-bottom: 70px;
        }
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>

    </script>
@endpush
