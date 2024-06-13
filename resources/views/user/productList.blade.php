@extends('layouts.main')

@section('content')
    <div class="product-list-container" style="background: #171716;">
        <div class="container" style="height: 125rem;">
            <div class="row justify-content-center" >
                <div class="col-md-12 col-xl-10 text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="title-product-list text-uppercase fw-bold">ALL {{ $products->first()->product_name }}</h1>
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
                </div>
            </div>
            @if($products->isNotEmpty())
                <div id="productList" data-type="{{ $products->isNotEmpty() ? $products->first()->type : '' }}" data-category="{{ $products->isNotEmpty() ? $products->first()->product_name : '' }}">
                    {{-- @foreach ($products->take(10) as $p)
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
                                                            <a href="{{ route('user.productDetail', ['type' => $p->type, 'name' => $p->product_name, 'id' => $p->product_id ]) }}" class="align-self-center">
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
                    @endforeach --}}
                </div>
            @else
                <h1 class="text-center mt-5 fw-bold">No Products Found</h1>
            @endif
            <div  id="pagination" class="d-flex justify-content-center">
                {{-- {{ $products->links('vendor.pagination.bootstrap-5') }} --}}
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
        $('#dropdownFilter').click(function () {
            var icon = $(this).find('.select-icon-filter');
            if (icon.hasClass('fa-chevron-down')) {
                icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else {
                icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }
        });

        $(document).ready(function () {
            var type = $('#productList').data('type');
            var category = $('#productList').data('category');

            // Perbarui URL dengan parameter halaman saat ini tanpa merefresh halaman
            var newUrl = `${window.location.pathname}?sort=Newest&page=1`;
            window.history.pushState({ path: newUrl }, '', newUrl);

            fetchFilteredProducts('Newest', type, category, 1);

            // Event handler untuk klik filter
            $('#filterOption a').click(function (event) {
                event.preventDefault();
                $('#filterOption a').removeClass('active');
                $(this).addClass('active');

                var sort = $(this).data('value');
                $('#dropdownFilter span').text(sort);

                var newUrl = `${window.location.pathname}?sort=${sort}&page=1`;
                window.history.pushState({ path: newUrl }, '', newUrl);

                fetchFilteredProducts(sort, type, category, 1);
            });

            // Delegeasi Event handler untuk klik pagination
            $(document).on('click', '#pagination a', function (event) {
                event.preventDefault();
                var url = $(this).attr('href'); // Ambil URL paginasi
                var page = url.split('page=')[1]; // Ambil page parameter query dari URL
                var sort = $('#filterOption a.active').data('value') || 'Newest'; // Gunakan filter yang dipilih atau default

                var newUrl = `${window.location.pathname}?sort=${sort}&page=${page}`;
                window.history.pushState({ path: newUrl }, '', newUrl);

                fetchFilteredProducts(sort, type, category, page);
            });

            $(window).on('popstate', function(event) {
                var params = new URLSearchParams(window.location.search);
                var sort = params.get('sort');
                var page = params.get('page');

                fetchFilteredProducts(sort, type, category, page);
            });

            // Fungsi untuk memuat ulang produk dengan filter dan pagination
            function fetchFilteredProducts(sort, type, category, page) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('user.filterProductList') }}",
                    method: 'GET',
                    data: {
                        sort: sort,
                        type: type,
                        product_name: category,
                        page: page
                    },
                    success: function (response) {
                        console.log(response);
                        $('#productList').empty();

                        if(response.products.length > 0){
                            response.products.forEach(function (product) {
                                var productHtml = `
                                    <div class="row justify-content-center mb-4">
                                        <div class="col-md-12 col-xl-10">
                                            <div class="card rounded-3 text-white" style="position: static;">
                                                <div class="row no-gutters">
                                                    <div class="col-md-3 img-product-container">
                                                        ${product.image ?
                                                            `<img class="img-product-table" src="/user/store/product/${product.image}" alt="Image Product">` :
                                                            `<img class="img-product-table" src="{{ asset('img/logo/LogoParts.jpg') }}" alt="Image Product" onerror="this.onerror=null;this.src='{{ asset('img/logo/LogoParts.jpg') }}';">`}
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="card-body card-product-list">
                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-8 col-xl-8">
                                                                    <h5>${product.name}</h5>
                                                                    <b>Product Description</b>
                                                                    <p class="text-truncate-description mb-4 mb-md-0">
                                                                        ${product.description}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-12 col-lg-4 col-xl-4 border-sm-start-none border-start">
                                                                    <div class="d-flex flex-row mb-1 justify-content-center">
                                                                        <h4 class="mb-1 me-1">Rp. ${new Intl.NumberFormat('id-ID').format(product.price)}</h4>
                                                                    </div>
                                                                    <div class="d-flex flex-column mt-4">
                                                                        <a href="/user/product-detail/${product.type}/${product.product_name}/${product.product_id}" class="align-self-center">
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
                                    </div>`;
                                $('#productList').append(productHtml);
                            });
                        } else {
                            var productHtml = `<h1 class="text-center fw-bold text-white mt-5 mb-5">No Products Found</h1>`;
                            $('#productList').append(productHtml);
                        }

                        // Perbarui link paginasi
                        $('#pagination').html(response.links);
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    </script>
@endpush
