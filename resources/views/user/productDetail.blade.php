@extends('layouts.main')

@section('content')
    <div class="product-detail-container" id="productDetail" data-type="{{ $products->type }}" data-category="{{ $products->product_name }}" style="background: #171716;">
        <input type="hidden" id="product_id" value="{{ $products->product_id }}">
        <div class="container" style="height: 88rem;">
            <div class="row" style="padding-top: 5rem; padding-bottom: 3rem;">
                <aside class="col-lg-5">
                    <div class="image-container rounded-4 d-flex justify-content-center">
                        @if($products->image)
                            <img class="img-product-detail border rounded-4" src="{{ route('user.store.productImage', ['imageName' => $products->image]) }}" alt="Image Product">
                        @else
                            <img class="img-product-detail border rounded-4" src="{{ asset('img/logo/LogoParts.jpg') }}" alt="Image Product" onerror="this.onerror=null;this.src='{{ asset('img/logo/LogoParts.jpg') }}';">
                        @endif
                    </div>
                </aside>
                <main class="col-lg-7">
                    <header class="mt-2 mb-2">
                        <h3 class="title text-white fw-bold">{{ $products->name }}</h3>
                    </header>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex my-3">
                                @if($favoriteProduct)
                                    <i id="iconFavorite" class="fas fa-heart fa-2x" data-user-id="{{ $userId }}" style="color: #ff0000; padding-right: 15px; cursor: pointer;"></i>
                                @else
                                    <i id="iconFavorite" class="far fa-heart fa-2x" data-user-id="{{ $userId }}" style="color: #ffffff; padding-right: 15px; cursor: pointer;"></i>
                                @endif
                                <div class="text-white mb-1 me-2">
                                    <h4 class="mb-1 me-1 fw-bold">Rp. {{ number_format($products->price, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex my-3">
                                <button class="btn rounded-3 btn-store me-2" style="background-color: #F26100;">
                                    <a class="text-decoration-none text-white" target="_blank" href="{{ $products->link_shopee }}">
                                        <img src="{{ asset('img/Logo/shopee.png') }}" style="width: 18px; padding-bottom: 6px;" alt="">
                                        <span>Buy In Shopee</span>
                                    </a>
                                </button>
                                <button class="btn rounded-3 btn-store" style="background-color: #19B400;">
                                    <a class="text-decoration-none text-white" target="_blank" href="{{ $products->link_tokopedia }}">
                                        <img src="{{ asset('img/Logo/tokopedia.png') }}" style="width: 18px; padding-bottom: 6px;" alt="">
                                        <span>Buy In Tokopedia</span>
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="container-description rounded-2 py-4 px-4">
                        <h3 class="text-white">Product Descriptions</h3>
                        <p class="text-white" style="height: 12rem;">
                            {{ $products->description }}
                        </p>
                        <hr class="text-white mt-4 mb-4"/>
                        <a class="store-profile-container text-decoration-none" target="_blank" href="">
                            <div class="store-profile-content">
                                @if($store->store_logo)
                                    <img class="img-store-profile border rounded-circle" src="{{ route('user.store.profileImage', ['imageName' => $store->store_logo]) }}" alt="Image Store Profile">
                                @else
                                    <img class="img-store-profile border rounded-circle" src="{{ asset('img/login/profile.jpg') }}" alt="Image Store Profile" onerror="this.onerror=null;this.src='{{ asset('img/login/profile.jpg') }}';">
                                @endif
                                <div class="text-white">
                                    <strong>{{ $store->store_name }}</strong><br>
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>{{ $store->store_address }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </main>
            </div>
            <div class="container-specs">
                <header class="mb-4">
                    <h3 class="text-white fw-bold">Product Specs</h3>
                </header>
                <div class="col-lg-12 mb-4 table-product-detail-specs">
                    <table class="table table-bordered table-product-specs text-white">
                        <tr>
                            <th class="row-product-specs py-2">Height</th>
                            <td class="row-product-specs py-2">{{ $products->height }} Cm</td>
                        </tr>
                        <tr>
                            <th class="row-product-specs py-2">Weight</th>
                            <td class="row-product-specs py-2">{{ $products->weight }} Kg</td>
                        </tr>
                        <tr>
                            <th class="row-product-specs py-2">Notes</th>
                            <td class="row-product-specs py-2">{{ $products->notes }}</td>
                        </tr>
                        <tr>
                            <th class="row-product-specs py-2">Part Type</th>
                            <td class="row-product-specs py-2">{{ $products->product_name }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="container-recommended">
                <header class="mb-4">
                    <h3 class="text-white fw-bold">Recommended For Your Car</h3>
                </header>
                <div class="position-relative">
                    <span id="prevBtn" class="btn-prev-next" style="left: -40px;">
                        <i class="fa fa-angle-double-left fa-2x" style="color: #F36600;"></i>
                    </span>
                    <div id="recommendedProduct" class="recommend-product-list row">
                        <!-- Produk akan dimasukkan di sini oleh JavaScript -->
                    </div>
                    <span id="nextBtn" class="btn-prev-next" style="right: -40px;">
                        <i class="fa fa-angle-double-right fa-2x" style="color: #F36600;"></i>
                    </span>
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
        .container-description {
            background: linear-gradient(117.11deg, rgba(44, 44, 58, 0.6) 0%, rgba(114, 114, 114, 0.25) 49.58%, rgba(44, 44, 58, 0.6) 99.17%);
            border-color: rgba(135, 135, 135, 0.2);
            border-width: 2px;
            border-style: solid;
            height: 25rem;
        }
        .img-product-detail {
            max-width: 93%;
            max-height: 100vh;
            margin: auto;
        }
        .img-store-profile {
            float: left;
            width: 70px;
            height: 70px;
            object-fit: cover;
            margin-right: 15px;
        }
        .btn-store {
            height:32px;
            padding: 2px 0px;
            width: 175px;
        }
        .store-profile-container {
            pointer-events: none;
        }
        .store-profile-content {
            display: flex;
            align-items: center;
        }
        .store-profile-content img,
        .store-profile-content .text-white {
            pointer-events: auto;
        }
        .table-product-detail-specs {
            background-color: #333;
            border-radius: 5px;
            border: 2px solid #5B5B5B;
            overflow: hidden;
        }
        .table-product-specs {
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }
        .table-product-specs th, .table-product-specs td {
            border: 1px solid #5B5B5B;
        }
        .row-product-specs {
            width:50%;
            font-size: 18px;
        }
        .recommend-product-list {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            flex-wrap: nowrap;
            scrollbar-width: none;
            margin: 0;
        }
        .btn-prev-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
        }
        .text-truncate-description {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 3rem;
        }
        .card-img-top {
            height: 180px;
            object-fit: contain;
        }

    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $('#iconFavorite').click(function() {
            var userId = $(this).data('user-id');
            if ($(this).hasClass("far fa-heart")) {
                if(userId){
                    $(this).removeClass("far fa-heart").addClass("fas fa-heart");
                    $(this).css("color", "#ff0000");

                    addFavoriteProduct();
                } else {
                    window.location.href = '/login';
                }
            } else {
                $(this).removeClass("fas fa-heart").addClass("far fa-heart");
                $(this).css("color", "#ffffff");
                removeFavoriteProduct();
            }
        });

        function addFavoriteProduct(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                },
                url: "{{ route('user.addFavoriteProduct') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    id: $('#product_id').val(),
                    type: $('#productDetail').data('type'),
                    product_name: $('#productDetail').data('category'),
                },
                success: function(response) {
                    console.log(response);
                }
            });
        }

        function removeFavoriteProduct(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                },
                url: "{{ route('user.removeFavoriteProduct') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    id: $('#product_id').val(),
                    type: $('#productDetail').data('type'),
                    product_name: $('#productDetail').data('category'),
                },
                success: function(response) {
                    console.log(response);
                }
            });
        }

        fetchRecommendedProducts();

        function fetchRecommendedProducts(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('user.recommendedProduct') }}",
                method: 'GET',
                data: {
                    type: $('#productDetail').data('type'),
                    product_name: $('#productDetail').data('category'),
                },
                success: function (response) {
                    console.log(response);
                    $('#recommendedProduct').empty();

                    response.products.forEach(function (product) {
                        var recommendedHtml = `
                        <div class="col-lg-3 col-md-6 col-sm-6" style="padding-right: 0; padding-left: 0; margin: 0 10px;">
                            <div class="card mb-4 mb-lg-0" style="padding: 1rem;">
                                <a href="/user/product-detail/${product.type}/${product.product_name}/${product.product_id}" class="pb-3">
                                    ${product.image ?
                                        `<img class="card-img-top rounded-2" src="/user/store/product/${product.image}" alt="Image Product">` :
                                        `<img class="card-img-top rounded-2" src="{{ asset('img/logo/LogoParts.jpg') }}" alt="Image Product" onerror="this.onerror=null;this.src='{{ asset('img/logo/LogoParts.jpg') }}';">`}
                                </a>
                                <div class="card-body d-flex flex-column pt-3 border-top" style="height: 6rem; padding: 0;">
                                    <a href="/user/product-detail/${product.type}/${product.product_name}/${product.product_id}" class="text-truncate-description nav-link fw-bold">${product.name}</a>
                                    <div class="price-wrap">
                                        <span class="fw-bold" style="color: #F36600; font-size: 17px;">Rp. ${new Intl.NumberFormat('id-ID').format(product.price)}</span>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        $('#recommendedProduct').append(recommendedHtml);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        var scrollAmount = 300;
        var scrollDuration = 10; // durasi animasi dalam milidetik

        $('#nextBtn').on('click', function() {
            $('#recommendedProduct').animate({
                scrollLeft: '+=' + scrollAmount
            }, scrollDuration);
        });

        $('#prevBtn').on('click', function() {
            $('#recommendedProduct').animate({
                scrollLeft: '-=' + scrollAmount
            }, scrollDuration);
        });

    </script>
@endpush
