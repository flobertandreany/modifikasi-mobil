@extends('layouts.main')

@section('content')
    <div class="find-store-container" style="background: #171716;">
        <div class="header-image" style="margin-bottom: 2rem;">
            <h1>SEARCH FOR A STORE</h1>
        </div>
        <div class="container" style="height: 37rem;">
            <div class="d-flex justify-content-center pb-4">
                <select id="citySelect">
                    <option selected value="0">Input The City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                <input class="form-control search-find-store" id="searchBar" type="search" placeholder="Search Store Name">
                <button class="btn me-2" id="btnSearch" style="background-color: #FBC536;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            @if($stores->isNotEmpty())
                <div class="find-store-list row" id="findStoreList">
                    @foreach ($stores as $s)
                        <div class="col-md-6 pb-4">
                            <div class="card mb-4 mb-lg-0 text-white" style="padding: .75rem; background-color: #414141;">
                                <h5 class="fw-bold">{{ $s->store_name }}</h5>
                                <span class="mb-1" style="color: #FBC536;">{{ $s->store_phone }}</span>
                                <span class="text-truncate-description mb-2"><i class="bi bi-geo-alt-fill me-1" style="color: white;"></i>{{ $s->store_address }}</span>
                                <div class="">
                                    <a href="{{ route('user.storeDetail', ['id' => $s->id ]) }}" class="btn btn-detail fw-bold"><i class="bi bi-gear-fill me-2"></i>
                                        See Details
                                    </a>
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
        .find-store-container {
            padding-top: 3.5rem;
            padding-bottom: 100px;
        }
        .find-store-list {
            height: 100%;
            overflow-y: auto;
            scrollbar-width: none;
            margin: 0 5rem;
        }
        .card {
            margin-bottom: 1rem;
        }
        .select2-container {
            width: 230px !important;
        }
        .select2-container .select2-selection--single {
            padding-top: 3px;
            height: 37px;
            border-radius: 6px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 37px;
        }
        .search-find-store {
            width:30%;
            margin: 0 .5rem;
        }
        .text-truncate-description {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 3rem;
        }
        .btn-detail, .btn-detail:hover {
            color: #171716;
            background-color: #FBC536;
            padding: .2rem 1rem .2rem .5rem;
            font-size: 14px;
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
        $.ajax({
            url: "{{ route('user.autocompleteStore') }}",
            method: 'GET',
            success: function (data) {
                $('#searchBar').autocomplete({
                    source: data
                });
            }
        });

        $("#citySelect").select2();
        $("#citySelect").change(function() {
            var cityId = $(this).children("option:selected").val();
            var cityName = $(this).children("option:selected").text();

            fetchStoreList(cityId, $('#searchBar').val());
        });

        $('#btnSearch').click(function() {
            var searchInput = $('#searchBar').val();

            fetchStoreList($('#citySelect').val(), searchInput);
        });

        $('#searchBar').keypress(function(event) {
            if (event.which == 13) { // 13 adalah kode ASCII untuk tombol Enter
                var searchInput = $('#searchBar').val();
                $('#searchBar').autocomplete('close');

                fetchStoreList($('#citySelect').val(), searchInput);
            }
        });

        function fetchStoreList(cityId, searchInput){
            $.ajax({
                url: "{{ route('user.filterFindStore') }}",
                method: 'GET',
                data: {
                    city: cityId,
                    search: searchInput
                },
                success: function (response) {
                    // console.log(response);
                    $('#findStoreList').empty();
                    if(response.stores.length > 0){
                        response.stores.forEach(function (store) {
                            var storeListHtml = `
                            <div class="col-md-6 pb-4">
                                <div class="card mb-4 mb-lg-0 text-white" style="padding: .75rem; background-color: #414141;">
                                    <h5 class="fw-bold">${store.store_name}</h5>
                                    <span class="mb-1" style="color: #FBC536;">${store.store_phone}</span>
                                    <span class="text-truncate-description mb-2"><i class="bi bi-geo-alt-fill me-1" style="color: white;"></i>${store.store_address}</span>
                                    <div class="">
                                        <a href="/user/store/detail/${store.id}" class="btn btn-detail fw-bold"><i class="bi bi-gear-fill me-2"></i>
                                            See Details
                                        </a>
                                    </div>
                                </div>
                            </div>`;

                            $('#findStoreList').append(storeListHtml);
                        });
                    } else {
                        var storeListHtml = `<h1 class="text-center fw-bold text-white mt-5 mb-5">No Stores Found</h1>`;
                        $('#findStoreList').append(storeListHtml);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
@endpush
