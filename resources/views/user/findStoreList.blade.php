@extends('layouts.main')

@section('content')
    <div class="find-store-container" style="background: #171716;">
        <div class="header-image mb-5">
            <h1>SEARCH FOR A STORE</h1>
        </div>
        <div class="container" style="height: 43rem;">
            <div class="row justify-content-center" >
                <div class="col-md-12 col-xl-10">
                    <div class="d-flex justify-content-center pb-4">
                        {{-- <select class="form-select select-find-store me-2">
                            <option selected>Input The City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <input class="form-control search-find-store me-2" type="text" placeholder="Search Store Name">
                        <button class="btn me-2" style="background-color: #FBC536;">
                            <i class="fas fa-search"></i>
                        </button> --}}
                        <div class="dropdown me-2">
                            <button class="btn btn-light select-find-store" type="button" id="dropdownFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                Input The City
                                <i class="fas fa-chevron-down select-icon"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuFilter">
                                @foreach($cities as $city)
                                    <li data-id="{{ $city->id }}">{{ $city->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <input class="form-control search-find-store me-2" type="text" placeholder="Search Store Name">
                        <button class="btn me-2" style="background-color: #FBC536;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    @if($stores->isNotEmpty())
                        <div class="favorite-product-list row" id="favoriteList">
                            @foreach ($stores as $s)
                                {{-- <div class="col-lg-3 col-md-6 col-sm-6 pb-4">
                                    <div class="card mb-4 mb-lg-0" style="padding: 1rem;">
                                        <a href="{{ route('user.productDetail', ['type' => $p->type, 'name' => $p->product_name, 'id' => $p->id ]) }}" class="pb-3">
                                            @if($p->image)
                                                <img class="card-img-top rounded-2" src="{{ route('user.store.productImage', ['imageName' => $p->image]) }}" alt="Image Product">
                                            @else
                                                <img class="card-img-top rounded-2" src="{{ asset('img/logo/LogoParts.jpg') }}" alt="Image Product" onerror="this.onerror=null;this.src='{{ asset('img/logo/LogoParts.jpg') }}';">
                                            @endif
                                        </a>
                                        <div class="card-body d-flex flex-column pt-3 border-top" style="height: 6rem; padding: 0;">
                                            <a href="{{ route('user.productDetail', ['type' => $p->type, 'name' => $p->product_name, 'id' => $p->id ]) }}" class="text-truncate-description nav-link fw-bold">{{ $p->name }}</a>
                                            <div class="price-wrap">
                                                <span class="fw-bold" style="color: #F36600; font-size: 17px;">Rp. {{ number_format($p->price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            {{-- <div class="card-body">
                                                <h5 class="card-title">{{ $stores->store_name }}</h5>
                                                <p class="card-text">{{ $stores->store_phone }}</p>
                                                <p class="card-text">{{ $stores->store_address }}</p>
                                                <a href="#" class="btn btn-primary">Go somewhere</a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- <div class="row">
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Special title treatment</h5>
                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                            <a href="#" class="btn btn-primary">Go somewhere</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Special title treatment</h5>
                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                            <a href="#" class="btn btn-primary">Go somewhere</a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    @else
                        <h1 class="text-center mt-5 fw-bold text-white">No Products Found</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .find-store-container {
            padding-top: 3.5rem;
            padding-bottom: 100px;
        }
        .favorite-product-list {
            height: 100%;
            overflow-y: auto;
            scrollbar-width: none;
        }
        .dropdown-menu {
            max-height: 250px;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .select-find-store{
            width: 230px;
            text-align: left;
        }
        .search-find-store {
            width:35%;
        }
        .card-img-top {
            height: 180px;
            object-fit: contain;
        }
        .text-truncate-description {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 3rem;
        }
        .header-image {
            position: relative; /* Penting untuk pseudo-element positioning */
            background-image: url('../img/login/Background find stores.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 170px;
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
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $('#dropdownFilter').click(function () {
            var icon = $(this).find('.select-icon');
            if (icon.hasClass('fa-chevron-down')) {
                icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else {
                icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }
        });

        var newUrl = `${window.location.pathname}?sort=Newest`;
        window.history.pushState({ path: newUrl }, '', newUrl);

        $('#filterOption a').click(function (event) {
            event.preventDefault();
            $('#filterOption a').removeClass('active');
            $(this).addClass('active');

            var sort = $(this).data('value');
            $('#dropdownFilter span').text(sort);

            var newUrl = `${window.location.pathname}?sort=${sort}`;
            window.history.pushState({ path: newUrl }, '', newUrl);

            fetchFavoriteProducts(sort);
        });

        function fetchFavoriteProducts(sort){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('user.filterFavoriteList') }}",
                method: 'GET',
                data: {
                    sort: sort,
                },
                success: function (response) {
                    // console.log(response);
                    $('#favoriteList').empty();

                    response.products.forEach(function (product) {
                        var recommendedHtml = `
                        <div class="col-lg-3 col-md-6 col-sm-6 pb-4">
                            <div class="card mb-4 mb-lg-0" style="padding: 1rem;">
                                <a href="/user/product-detail/${product.type}/${product.product_name}/${product.id}" class="pb-3">
                                    ${product.image ?
                                        `<img class="card-img-top rounded-2" src="/user/store/product/${product.image}" alt="Image Product">` :
                                        `<img class="card-img-top rounded-2" src="{{ asset('img/logo/LogoParts.jpg') }}" alt="Image Product" onerror="this.onerror=null;this.src='{{ asset('img/logo/LogoParts.jpg') }}';">`}
                                </a>
                                <div class="card-body d-flex flex-column pt-3 border-top" style="height: 6rem; padding: 0;">
                                    <a href="/user/product-detail/${product.type}/${product.product_name}/${product.id}" class="text-truncate-description nav-link fw-bold">${product.name}</a>
                                    <div class="price-wrap">
                                        <span class="fw-bold" style="color: #F36600; font-size: 17px;">Rp. ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        $('#favoriteList').append(recommendedHtml);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
@endpush
