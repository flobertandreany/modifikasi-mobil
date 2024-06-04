@extends('layouts.main')

@section('content')
    <div class="d-flex">
        <a href="{{ route('view.store.list') }}" class="btn-back"><i class="fa fa-arrow-left fa-2x"></i></a>
        <h1 style="color: white; margin-bottom: 30px; margin-left: 1rem;">{{ $title }}</h1>
    </div>
    <div>
        <table class="table table-bordered border-dark bg-white" style="border-radius : 5px; overflow: hidden; text-align: center;">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Height</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $p)
                    <tr>
                        <th scope="row" class="center-position" style="width:5%;">{{ $loop->index + 1 }}.</th>
                        <td style="text-align: left; width:50%;">
                            @if($p->image)
                                <img class="img-product-table" src="{{ route('store.productImage', ['imageName' => $p->image]) }}" alt="Image Product">
                            @else
                                <img class="img-product-table" src="{{ asset('img/logo/LogoParts.jpg') }}" alt="Image Product" onerror="this.onerror=null;this.src='{{ asset('img/logo/LogoParts.jpg') }}';">
                            @endif
                            <div>
                                <strong>{{ $p->product_name }}</strong><br>
                                {{ $p->name }}
                            </div>
                        </td>
                        <td class="center-position" style="width:10%;">{{ $p->height }} Cm</td>
                        <td class="center-position" style="width:10%;">{{ $p->weight }} Kg</td>
                        <td class="center-position" style="width:15%;">Rp. {{ number_format($p->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                @for ($i = count($products); $i < 5; $i++)
                    <tr style="height: 5rem;">
                        <th scope="row" class="center-position">{{ $i + 1 }}.</th>
                        <td class="">&nbsp;</td>
                        <td class="">&nbsp;</td>
                        <td class="">&nbsp;</td>
                        <td class="">&nbsp;</td>
                        <td class="">&nbsp;</td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {{ $products->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .btn-add {
            position: absolute;
            bottom: 0;
        }
        .center-position {
            vertical-align: middle;
        }
        .img-product-table {
            float: left;
            margin-left:20px;
            margin-right: 30px;
            height: 4em;
            width: 4em;
            transition: 0.7s ease;
        }
        .img-product-table:hover {
            transform: scale(3);
        }
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>

    </script>
@endpush
