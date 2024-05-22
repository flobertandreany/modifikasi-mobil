@extends('layouts.main')

@section('content')
    <h1 style="color: white; margin-bottom: 30px;">{{ $title }}</h1>

    <div class="container">
        <div class="div-utama">
            <table class="table-utama table table-bordered border-dark bg-white">
                <thead>
                  <tr style="background-color: rgb(224, 224, 224);">
                    <th scope="col">No.</th>
                    <th scope="col">Shop Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Details</th>
                    <th scope="col">Settings</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($store as $s)
                        <tr>
                            <td scope="row">{{ $loop->index + 1 }}.</td>
                            <td>{{ $s->store_name}}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->store_phone }}</td>
                            <td>
                                <button type="button" class="button-detail btn btn-secondary btn-sm open-modal" data-bs-toggle="modal" data-bs-target="#popupStore{{ $s->id }}">
                                    See Details
                                </button>
                            </td>
                            <td style="border-right: 0px; padding: 15px 0 15px 0;">
                                {{-- <form id="rejectForm{{ $s->id }}" action="store/reject/{{ $s->id }}" method="POST">
                                    @csrf --}}
                                    <button type="submit" name="reject" onclick="reject_button({{ $s->id }})" class="button-a btn btn-sm" style="background-color: red; margin-right: 20px;">
                                        Decline
                                    </button>
                                    <button type="submit" name="approve" onclick="approve_button({{ $s->id }})" class="button-a btn btn-sm" style="background-color: rgb(0, 192, 0);">
                                        Approve
                                    </button>
                                {{-- </form> --}}
                            </td>
                            {{-- <td> --}}
                                {{-- <form id="approvalForm{{ $s->id }}" action="store/approval/{{ $s->id }}" method="POST">
                                    @csrf --}}
                                {{-- </form> --}}
                            {{-- </td> --}}
                        </tr>

                        <div class="modal fade" id="popupStore{{ $s->id }}" tabindex="-1" aria-labelledby="popupStoreLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content modal-custom">
                                    {{-- <div class="modal-header">
                                        <h5 class="modal-title" id="popupStoreLabel">Store {{ $s->store_name }} Detail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div> --}}
                                    <div class="modal-body">
                                        <div id="store-details{{ $s->id }}">
                                            <h4 class="modal-title" style="font-weight: bold; margin-bottom: 40px;" id="popupStoreLabel">Store {{ $s->store_name }} Detail</h4>
                                            <button type="button" class="btn-close btn-close-red" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <div class="row g-3" style="margin-bottom: 30px;">
                                                <div class="col-md-5 custom-column">
                                                    <label for="name" class="form-label">Store Name</label>
                                                    <input type="name" class="form-control" id="name" value="{{ $s->store_name }}" readonly>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="inputAddress" class="form-label">Subdisctrict</label>
                                                    <input type="text" class="form-control" id="inputAddress" value="{{ $s->subdistrict_name }}" readonly>
                                                </div>
                                                <div class="col-md-5 custom-column">
                                                    <label for="inputAddress2" class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="inputAddress2" value="{{ $s->email }}" readonly>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="inputAddress" class="form-label">Postal Code</label>
                                                    <input type="text" class="form-control" id="inputAddress" value="{{ $s->store_postal_code }}" readonly>
                                                </div>
                                                <div class="col-md-5 custom-column">
                                                    <label for="inputAddress2" class="form-label">Store Phone Number</label>
                                                    <input type="text" class="form-control" id="inputAddress2" value="{{ $s->store_phone }}" readonly>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="address" class="form-label">Store Address</label>
                                                    <input type="email" class="form-control" id="inputEmail4" value="{{ $s->store_address }}" readonly>
                                                </div>
                                                <div class="col-md-5 custom-column">
                                                    <label for="inputAddress" class="form-label">Province</label>
                                                    <input type="text" class="form-control" id="inputAddress" value="{{ $s->province_name }}" readonly>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="inputAddress2" class="form-label">Store Tokopedia</label>
                                                    <input type="text" class="form-control" id="inputAddress2" value="{{ $s->store_tokopedia }}" readonly>
                                                </div>
                                                <div class="col-md-5 custom-column">
                                                    <label for="inputCity" class="form-label">City</label>
                                                    <input type="text" class="form-control" id="inputCity" value="{{ $s->city_name }}" readonly>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="inputAddress2" class="form-label">Store Shoope</label>
                                                    <input type="text" class="form-control" id="inputAddress2" value="{{ $s->store_shopee }}" readonly>
                                                </div>
                                                <div class="col-md-5 custom-column">
                                                    <label for="inputAddress" class="form-label">Store District</label>
                                                    <input type="text" class="form-control" id="inputAddress" value="{{ $s->district_name }}" readonly>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="inputAddress2" class="form-label">Store Instagram</label>
                                                    <input type="text" class="form-control" id="inputAddress2" value="{{ $s->store_instagram }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </tbody>

            </table>

            @if ($store->links()->paginator->hasPages())
                <div class="pagination d-flex justify-content-center my-4">
                    {{ $store->links() }}
                </div>
            @endif
        </div>

    </div>
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

        .table-utama{
            text-align: center;
            vertical-align: middle;
        }
        .div-utama{
            width:100%;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .modal-custom {
            width:5000px;
            /* height:90%; */
            margin: auto;
        }

        .custom-column {
            margin-right: 100px;
        }

        .col-md-5{
            margin-left: 10px;
            text-align: left;
        }

        .form-label{
            padding-left: 5px;
            font-weight: bold;
            font-size: 17px;
        }

        .button-detail{
            border-radius: 100px;
            width: 100px;
            font-size: 13px;
            background-color: black;
        }

        .button-a{
            border-radius: 100px;
            width: 100px;
            font-size: 13px;
            color: white;
        }

        /* .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-item .page-link {
            color: #F36600;
        }

        .pagination .page-item.active .page-link {
            background-color: #F36600;
            border-color: #F36600;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            cursor: not-allowed;
        } */
    </style>

@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function reject_button(id) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure want to decline this Store ?',
                text: 'This will decline this store permanently, and you cannot undo this action.',
                showCancelButton: true,
                confirmButtonText: 'Decline',
                confirmButtonColor: '#F36600',
            }).then((result) => {
                if (result.isConfirmed) {
                    // var form = document.getElementById("rejectForm" + id);
                    // form.submit();
                    window.location.href = '/store/reject/' + id;
                }
            });
        }

        function approve_button(id) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure want to approve this Store ?',
                text: 'This will approve this store, and you cannot undo this action.',
                showCancelButton: true,
                confirmButtonText: 'Approve',
                confirmButtonColor: '#F36600',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/store/approval/' + id;
                }
            });
        }

    </script>
@endpush
@endsection
