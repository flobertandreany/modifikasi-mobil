@extends('layouts.main')

@section('content')
    <h1 style="color: white; margin-bottom: 30px;">{{ $title }}</h1>

    <div>
        <table class="table-utama table table-bordered border-dark bg-white">
            <thead>
                <tr style="background-color: rgb(224, 224, 224);">
                    <th scope="col">No</th>
                    <th scope="col">Brand Photo</th>
                    <th scope="col">Brand Name</th>
                    <th scope="col">Settings</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brand as $b)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}.</th>
                        <td>
                            <img src="{{ route('brand.image', ['imageName' => $b->car_brand_logo]) }}" alt="Brand Logo" width="100px" height="100px">
                        </td>
                        <td>{{ $b->car_brand_name }}</td>
                        <td style="width:300px;">
                                <a href="{{ route('brand.edit', ['id' => $b->id]) }}" class="button-a btn btn-secondary btn-sm" style="background-color: black; margin-right: 10px;">Edit</a>
                                <button onclick="delete_button({{ $b->id }})" class="button-a btn btn-secondary btn-sm" style="background-color: red;">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            <div class="d-flex justify-content-center">
                <a href="{{ route('car.brand.form') }}" class="btn btn-light btn-add">
                    <i class="fa fa-plus" style="color: #000000;"></i> Add Car Brand
                </a>
            </div>
    </div>
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .button-a{
            border-radius: 100px;
            width: 100px;
            font-size: 13px;
        }
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function delete_button(id) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure want to delete this Car Brand ?',
                text: 'This will delete this brand permanently, and you cannot undo this action.',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#F36600',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/car/brand/delete/' + id;
                }
            });
        }


    </script>
@endpush
@endsection
