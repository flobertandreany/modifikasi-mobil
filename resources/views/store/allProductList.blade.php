@extends('layouts.main')

@section('content')
    <h1 style="color: white; margin-bottom: 30px;">{{ $title }}</h1>

    <div>
        <table class="table table-bordered border-dark bg-white" style="border-radius : 5px; overflow: hidden; text-align: center;">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Height</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Price</th>
                    <th scope="col">Settings</th>
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
                        <td class="center-position" style="width:10%;">
                            <a href="{{ route('store.editProductForm', ['id' => $p->id, 'type' => $p->type]) }}" class="button-a btn btn-secondary btn-sm" style="background-color: black; margin-right: 10px;">Edit</a>
                            <button class="btn btn-sm text-light" data-id="{{ $p->id }}" data-type="{{ $p->type }}" onclick="delete_button(this)" type="button" style="background-color: #FF0000;">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
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
        <div class="d-flex justify-content-center">
            <button id="" class="btn btn-light btn-add" type="button">
                <a href="{{ route('store.productForm') }}" class="text-decoration-none text-dark">
                    <i class="fa fa-plus me-2" style="color: #000000;"></i>
                    <span class="fw-bold">Add Product</span>
                </a>
            </button>
        </div>
    </div>
@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
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
        function delete_button(element) {
            var type = element.getAttribute('data-type');
            var id = element.getAttribute('data-id');
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure want to delete this Product ?',
                text: 'This will delete this product permanently, and you cannot undo this action.',
                showCancelButton: true,
                confirmButtonColor: '#FF0000',
                cancelButtonColor: '#FFFFFF',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'delete-button-swal',
                    cancelButton: 'cancel-button-swal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(type, id);
                    window.location.href = '/store/product/delete/' + type + '/' + id;
                }
            });
        }
    </script>
@endpush
