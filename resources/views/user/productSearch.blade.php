@extends('layouts.main')

@section('content')
    <div class="product-list-container" style="background: #171716;">
        <div class="container" style="height: 125rem;">
            <div class="row justify-content-center" >
                <div class="col-md-12 col-xl-10 text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="title-product-list fw-bold">Search result for '{{ $searchKeywords }}'</h3>
                    </div>
                </div>
            </div>
            @if($products->isNotEmpty())
                <div id="productList">
                    @foreach ($products->take(10) as $p)
                        <div class="row justify-content-center mb-4">
                            <div class="col-md-12 col-xl-10">
                                <div class="card rounded-3 text-white" style="position: static;">
                                    <div class="row no-gutters">
                                        <div class="col-md-3 img-product-container">
                                            @if($p->image)
                                                <img class="img-product-table" src="{{ route('user.store.productImage', ['imageName' => $p->image]) }}" alt="Image Product">
                                            @else
                                                <img class="img-product-table" src="{{ asset('img/logo/LogoParts.jpg') }}" alt="Image Product" onerror="this.onerror=null;this.src='{{ asset('img/logo/LogoParts.jpg') }}';">
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body card-product-list">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-8 col-xl-8">
                                                        <h5>{{ $p->name }}</h5>
                                                        <b>Product Description</b>
                                                        <p class="text-truncate-description mb-4 mb-md-0">
                                                            {{ $p->description }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-12 col-lg-4 col-xl-4 border-sm-start-none border-start">
                                                        <div class="d-flex flex-row mb-1 justify-content-center">
                                                            <h4 class="mb-1 me-1">Rp. {{ number_format($p->price, 0, ',', '.') }}</h4>
                                                        </div>
                                                        <div class="d-flex flex-column mt-4">
                                                            <a href="{{ route('user.productDetail', ['type' => $p->type, 'name' => $p->product_name, 'id' => $p->id ]) }}" class="align-self-center">
                                                                <button class="btn text-white" type="button" style="background: black;">
                                                                    <span class="fw-bold">Detail</span>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h1 class="text-center mt-5 mb-5 fw-bold text-white">No Products Found</h1>
            @endif
            <div  id="pagination" class="d-flex justify-content-center">
                {{ $products->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .product-list-container {
            padding-top: 6rem;
            padding-bottom: 70px;
        }

        .img-product-container {
            background-color: white;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .img-product-table {
            margin-left: 1.5rem;
            margin-top: 10px;
            height: 143px;
            width: 185px;
            transition: 0.7s ease;
        }

        .img-product-table:hover {
            transform: scale(1.5);
        }

        .title-product-list {
            padding-top: 3rem;
            padding-bottom: 2rem;
        }

        .row {
            padding-right: 0;
            margin-left: 0;
        }

        .card-product-list {
            border-top-right-radius: 7px;
            border-bottom-right-radius: 7px;
            background: #363636;
            min-height: 10rem;
        }

        .text-truncate-description {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
    </script>
@endpush
