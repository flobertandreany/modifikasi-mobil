@extends('layouts.main')

@section('content')
    <h1 style="color: white; margin-bottom: 30px;">{{ $title }}</h1>

    <div>
        <table class="table-utama table table-bordered border-dark bg-white">
            <thead>
                <tr style="background-color: rgb(224, 224, 224);">
                    <th scope="col">No</th>
                    <th scope="col">Parts Type</th>
                    <th scope="col">Parts Name</th>
                    <th scope="col">Settings</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($parts as $p)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}.</th>
                        <td>
                            @if ($p->product_category_id == 1)
                                Spare Parts
                            @elseif ($p->product_category_id == 2)
                                Modification</td>
                            @endif
                        <td>{{ $p->product_name }}</td>
                        <td style="width:300px; padding: 15px 0 15px 0;">
                                <a href="{{ route('part.edit', ['id' => $p->id]) }}" class="button-a btn btn-secondary btn-sm" style="background-color: black; margin-right: 10px;">Edit</a>
                                <button onclick="delete_button({{ $p->id }})" class="button-a btn btn-secondary btn-sm" style="background-color: red;">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            {{-- <a href="{{ route('model.form') }}" class="btn btn-primary">Add New Model</a> --}}
            <div class="d-flex justify-content-center">
                <a href="{{ route('part.form') }}" class="btn btn-light btn-add">
                    <i class="fa fa-plus" style="color: #000000;"></i> Add Car Part
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
                title: 'Are you sure want to delete this Part ?',
                text: 'This will delete this car part permanently, and you cannot undo this action.',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#F36600',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/car/parts/delete/' + id;
                }
            });
        }


    </script>
@endpush
@endsection
