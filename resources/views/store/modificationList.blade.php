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
                {{-- @foreach ($brand as $b)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}.</th>
                        <td>
                            <img src="{{ asset('img/brand/' . $b->car_brand_logo) }}" alt="Brand Logo" width="100px" height="100px">
                        </td>
                        <td>{{ $b->car_brand_name }}</td>
                        <td>
                            <button>
                                <a href="{{ route('car.brand.edit', $b->id) }}" class="btn btn-primary">Edit</a>
                            </button>
                            <button>
                                <a href="{{ route('car.brand.delete', $b->id) }}" class="btn btn-danger">Delete</a>
                            </button>
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <button id="" class="btn btn-light btn-add" type="button">
                <i class="fa fa-plus" style="color: #000000;"></i> Add Product
            </button>
        </div>
    </div>
@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .btn-add {
            position: absolute;
            bottom: 0;
            margin-bottom: 2rem;
        }
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>

    </script>
@endpush
