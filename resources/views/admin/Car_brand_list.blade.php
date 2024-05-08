@extends('layouts.main_adminStore')

@section('content')
    <h1 style="color: white; margin-bottom: 30px;">{{ $title }}</h1>

    <div>
        <table class="table table-bordered border-dark bg-white" style="border-radius : 5px; overflow: hidden; text-align: center;">
            <thead>
                <tr>
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
                            <img src="{{ asset('img/brand/' . $b->car_brand_logo) }}" alt="Brand Logo" width="100px" height="100px">
                        </td>
                        <td>{{ $b->car_brand_name }}</td>
                        <td>
                            <button>
                                {{-- <a href="{{ route('car.brand.edit', $b->id) }}" class="btn btn-primary">Edit</a> --}}
                            </button>
                            <button>
                                {{-- <a href="{{ route('car.brand.delete', $b->id) }}" class="btn btn-danger">Delete</a> --}}
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button>
            <a href="{{ route('car.brand.form') }}" class="btn btn-primary">Add New Brand</a>
        </button>
    </div>

    <script>

    </script>

@endsection
