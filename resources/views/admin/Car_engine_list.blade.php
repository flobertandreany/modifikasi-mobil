@extends('layouts.main')

@section('content')
    <h1 style="color: white; margin-bottom: 30px;">{{ $title }}</h1>

    <div>
        <table class="table-utama table table-bordered border-dark bg-white">
            <thead>
                <tr style="background-color: rgb(224, 224, 224);">
                    <th scope="col">No</th>
                    <th scope="col">Car Brand</th>
                    <th scope="col">Car Model</th>
                    <th scope="col">Car Year</th>
                    <th scope="col">Car Engine</th>
                    <th scope="col">Settings</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($engine as $m)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}.</th>
                        <td>{{ $m->car_brand_name }}</td>
                        <td>{{ $m->car_model_name }}</td>
                        <td>{{ $m->car_year }}</td>
                        <td>{{ $m->engine_name }}</td>
                        <td style="width:300px; padding: 15px 0 15px 0;">
                                <a href="{{ route('engine.edit', ['id' => $m->id]) }}" class="button-a btn btn-secondary btn-sm" style="background-color: black; margin-right: 10px;">Edit</a>
                                <button onclick="delete_button({{ $m->id }})" class="button-a btn btn-secondary btn-sm" style="background-color: red;">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            <div class="d-flex justify-content-end">
                {{ $engine->links('vendor.pagination.bootstrap-5') }}
            </div>
            {{-- <a href="{{ route('model.form') }}" class="btn btn-primary">Add New Model</a> --}}
            <div class="d-flex justify-content-center">
                <a href="{{ route('engine.form') }}" class="btn btn-light btn-add">
                    <i class="fa fa-plus" style="color: #000000;"></i> Add Car Engine
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
                title: 'Are you sure want to delete this Car Engine ?',
                text: 'This will delete this model permanently, and you cannot undo this action.',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#F36600',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/car/engine/delete/' + id;
                }
            });
        }


    </script>
@endpush
@endsection
