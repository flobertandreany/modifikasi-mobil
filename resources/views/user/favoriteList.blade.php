@extends('layouts.main')

@section('content')
<div class="favorite-container" style="background: #171716;">
        {{-- <input type="hidden" id="product_id" value="{{ $products->product_id }}"> --}}
        <div class="container" style="height: 43rem;">
            <div class="d-flex justify-content-between align-items-center text-white pb-4">
                <h1 class="title-product-list text-uppercase fw-bold">My Favorites</h1>
                <div class="d-flex align-items-center">
                    <h4 class="title-product-list me-3">Filter</h4>
                    <div class="title-product-list">
                        <button id="dropdownFilter" class="btn btn-filter rounded-3 d-flex justify-content-between" type="button" data-bs-toggle="dropdown">
                            <span class="text-white">Newest</span>
                            <i class="fas fa-chevron-down select-icon-filter"></i>
                        </button>
                        <ul id="filterOption" class="dropdown-menu text-white btn-filter" aria-labelledby="dropdownFilter">
                            <li><a class="text-white text-decoration-none" href="#" data-value="Newest">Newest</a></li>
                            <li><a class="text-white text-decoration-none" href="#" data-value="Oldest">Oldest</a></li>
                            <li><a class="text-white text-decoration-none" href="#" data-value="Lowest Price">Lowest Price</a></li>
                            <li><a class="text-white text-decoration-none" href="#" data-value="Highest Price">Highest Price</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @if($products->isNotEmpty())
                <div class="favorite-product-list row" id="favoriteList">
                    @foreach ($products as $p)
                        <div class="col-lg-3 col-md-6 col-sm-6 pb-4">
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
                        </div>
                    @endforeach
                </div>
            @else
                <h1 class="text-center mt-5 fw-bold text-white">No Products Found</h1>
            @endif
        </div>
    </div>
@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .favorite-container {
            padding-top: 6rem;
            padding-bottom: 100px;
        }
        .select-icon-filter {
            color: white !important;
            padding-top: 5px;
        }
        .btn-filter, .btn-filter:hover, .btn-filter.show {
            border: 1px solid white;
            background-color: #F36600;
            padding: 7px;
            width: 155px;
        }
        .favorite-product-list {
            height: 100%;
            overflow-y: auto;
            scrollbar-width: none;
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

    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $('#dropdownFilter').click(function () {
            var icon = $(this).find('.select-icon-filter');
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
