@extends('layouts.main')

@section('content')
    <div class="store-detail-container" style="background: black;">
        <div class="container detail-toko-container">
            <div class="detail-toko row g-3">
                <div class="col-md-2 div-luar-img-toko">
                    <div class="store-image div-img-toko">
                        @if($store->store_logo)
                            <img src="{{ route('store.profileImage', ['imageName' => $store->store_logo]) }}" alt="store" class="img-fluid img-toko">
                        @else
                            <img src="{{ asset('img/login/profile.jpg') }}" alt="store" class="img-fluid img-toko">
                        @endif
                    </div>
                </div>
                <div class="col-md-8 d-flex">
                    <div class="store-info d-flex flex-row">
                        <div class="d-flex flex-column div-store-info">
                            <h3 class="store-name">{{ $store->store_name }}</h3>
                            <p>
                                <i class="bi bi-geo-alt-fill"></i>
                                <span style="color: white;">{{ $store->store_address }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 div-luar-button">
                    <div class="store-action d-flex flex-row">
                        <div class="d-flex flex-column" style="justify-content: space-evenly;">
                            <button class="btn rounded-3 btn-store" style="background-color: #F26100;">
                                <a class="text-decoration-none text-white" target="_blank" href="{{ $store->store_shopee }}">
                                    <img src="{{ asset('img/Logo/shopee.png') }}" style="width: 18px; padding-bottom: 6px;" alt="">
                                    <span>Buy In Shopee</span>
                                </a>
                            </button>
                            <button class="btn rounded-3 btn-store" style="background-color: #19B400;">
                                <a class="text-decoration-none text-white" target="_blank" href="{{ $store->store_tokopedia }}">
                                    <img src="{{ asset('img/Logo/tokopedia.png') }}" style="width: 18px; padding-bottom: 6px;" alt="">
                                    <span>Buy In Tokopedia</span>
                                </a>
                            </button>
                        </div>
                        {{-- <div class="d-flex flex-column">
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        @if ($products->isEmpty())
            <div class="container" style="text-align: center; padding-top: 100px;">
                <div style="font-size: 70px; color: white;">
                    product not found
                </div>
            </div>
        @else
        <div class="container detail-produk-container" style="padding-top: 35px;">
            <div class="detail-produk row g-3">
                <div class="col-md-2" style="padding-top: 15px;">
                    <div class="sort-produk">
                        <div class="d-flex flex-column">
                            <span style="font-size: larger; color: white;">By Type</span>
                            <div style="padding: 5px;">
                                <div style="padding-bottom: 15px;">
                                    <div class="products-sort">
                                        <a href="" class="text-decoration-none text-white" style="padding-left: 5px;">All Products</a>
                                    </div>
                                </div>
                                <div style="color: white;">
                                    Spare Parts
                                </div>
                                <div>
                                    @foreach ($part as $p)
                                    <div style="" class="products-sort">
                                        <li class="nav-item-user" style="list-style-type: none;">
                                            <a class="text-decoration-none" style="color: #D4D4D4 !important;" href="#" onclick="sortProduct({{ $p->product_id }}, {{ $p->product_category_id }}, {{ $p->store_id }}); return false;">
                                                {{ $p->product_name }}
                                            </a>
                                        </li>
                                    </div>
                                    @endforeach
                                </div>
                                <div style="color: white; padding-top: 15px;">
                                    Modification
                                </div>
                                <div>
                                    @foreach ($mod as $p)
                                    <div class="products-sort">
                                        <li class="nav-item-user" style="list-style-type: none;">
                                            <a class="text-decoration-none products-sort sortProduct"  style="color: #D4D4D4 !important;" href="#" data-value="{{ $p->id }}" data-category="{{ $p->product_category_id }}" data-store="{{ $p->store_id }}">
                                                {{ $p->product_name }}
                                            </a>
                                        </li>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 div-luar-produk">
                    <div class="judul-sort">
                        ALL PRODUCTS
                    </div>
                    <div id="productList"  class="row g-3 overflow-product" style="width: 92%; margin-left: 40px;">
                        @foreach ($products as $m)
                        <a class="col-md-4 card-button-store" href="{{ route('user.productDetail', ['type' => $m->type, 'name' => $m->product_name, 'id' => $m->id ]) }}">
                            <div class="card car-mod">
                                <div class="card-header header-recomend ">
                                    <img src="{{ route('store.productImage', ['imageName' => $m->image]) }}" class="card-img-top" style="max-width: 140px; margin: 10px 40px 10px 40px;" alt="...">
                                </div>
                                <div class="card-body card-body-recomend">
                                    <div class="judul-mod">
                                        {{ $m->name }}
                                    </div>
                                    <h5 class="price">Rp. {{ number_format($m->price, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

        .overflow-product {
            height: 935px !important;
            overflow-y: scroll; /* Hanya scroll secara vertikal */
            overflow-x: hidden; /* Sembunyikan scroll horizontal */
        }

        /* Sembunyikan scrollbar untuk browser WebKit (Chrome, Safari) */
        .overflow-product::-webkit-scrollbar {
            display: none;
        }

        /* Sembunyikan scrollbar untuk Firefox */
        .overflow-product {
            scrollbar-width: none; /* Firefox */
        }

        /* Sembunyikan scrollbar untuk Internet Explorer dan Edge */
        .overflow-product {
            -ms-overflow-style: none;  /* IE and Edge */
        }
        .judul-sort{
            color: white;
            font-size: 35px;
            padding-left: 30px;
            padding-bottom: 20px;
            font-weight: 800;
        }

        .products-sort:hover{
            background-color: #8E8E8E;
            border-radius: 5px;
        }

        .sort-produk{
            background-color: #3E3E3E;
            border: 1px solid #8E8E8E;
            box-shadow: 0px 4px 4px rgba(236.57, 236.57, 236.57, 0.25);
            border-radius: 5px;
            padding: 5px;
            font-family: monospace;
        }

        .div-store-info{
            vertical-align: middle;
            justify-content: center;
            padding-bottom: 30px;
        }

        .store-name{
            font-size: 3rem !important;
            text-transform: uppercase;
        }

        .div-luar-button{
            display: flex;
            justify-content: center;
            margin-bottom: 16px;
        }

        .div-luar-img-toko{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }

        .div-img-toko{
            text-align: center;
            border-radius: 999px;
            width: 138px;
            height: 138px;
        }

        .img-toko{
            border-radius: 999px;
            width: 138px;
            height: 138px;
        }

        .detail-toko-container{
            max-width: 1500px !important;
            align-items: center;
            justify-content: center;
            display: flex;
        }

        .detail-toko{
            background-color: grey;
            width: 90%;
            color: white;
            background: #3E3E3E;
            box-shadow: 0px 4px 4px rgba(236.57, 236.57, 236.57, 0.25);
            border-radius: 10px
        }

        .store-detail-container {
            padding-top: 100px;
            min-height: 140rem;
        }

        .card-button-store{
            height: 300px;
            width: 330px;
            text-decoration: none;
            color: inherit;
        }

        .card-button-store:hover{
            text-decoration: none;
            color: inherit;
        }

        .card-button-store:active{
            text-decoration: none;
            color: inherit;
        }

        .card-button-store:hover .judul-mod{
            color: inherit;
        }

    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.sortProduct', function (event) {
                event.preventDefault();
                var id = $(this).data('value');
                var category_id = $(this).data('category');
                var store_id = $(this).data('store');

                fetchFilteredProducts(id, category_id, store_id);
            });
        });

        function fetchFilteredProducts(id, category_id, store_id){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ route('user.filterStoreProductList') }}`,
                method: 'GET',
                data: {
                    product_id: id,
                    category_id: category_id,
                    store_id: store_id
                },
                success: function(response){
                    $('#productList').empty();

                    response.products.forEach(function (product){
                        var productHtml = `
                            <a class="col-md-4 card-button-store" href="/user/product-detail/${product.type}/${product.product_name}/${product.product_id}">
                                <div class="card car-mod">
                                    <div class="card-header header-recomend ">
                                        <img src="/user/store/product/${product.image}" class="card-img-top" style="max-width: 140px; margin: 10px 40px 10px 40px;" alt="...">
                                    </div>
                                    <div class="card-body card-body-recomend">
                                        <div class="judul-mod">
                                            ${product.name}
                                        </div>
                                        <h5 class="price">Rp. ${new Intl.NumberFormat('id-ID').format(product.price)}</h5>
                                    </div>
                                </div>
                            </a>
                        `;
                        $('#productList').append(productHtml);
                    });
                },
                error: function(xhr, status, error){
                    console.error(error);
                }
            })
        }

    </script>
@endpush
