@extends('layouts.main')

@section('content')
    <h1>{{ $title }}</h1>

    <div>
        <table class="table align-middle mb-0 bg-white">
            <thead>
              <tr>
                <th scope="col">No.</th>
                <th scope="col">Shop Name</th>
                <th scope="col">Tokopedia</th>
                <th scope="col">Phone</th>
                <th scope="col">Details</th>
                <th scope="col">Settings</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($store as $s)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $s->store_name}}</td>
                        <td>{{ $s->store_tokopedia }}</td>
                        <td>{{ $s->store_phone }}</td>
                        <td>
                            <button type="button" class="btn btn-primary open-modal" data-bs-toggle="modal" data-bs-target="#popupStore{{ $s->id }}">
                                Details
                            </button>
                        </td>
                        <td>
                            <form id="approvalForm{{ $s->id }}" action="store/approval/{{ $s->id }}" method="POST">
                                @csrf
                                <button type="submit" name="reject" class="btn btn-link btn-rounded btn-sm fw-bold" data-mdb-ripple-color="dark">
                                    Reject
                                </button>
                                @csrf
                                <button id="approve" name="approve" onclick="submit_approve({{ $s->id }})" type="submit" class="btn btn-link btn-rounded btn-sm fw-bold" data-mdb-ripple-color="dark">
                                    Approve
                                </button>
                            </form>
                        </td>
                    </tr>

                    <style>
                        .modal-custom {
                            width:5000px;
                            /* height:90%; */
                            margin: auto;
                        }

                        .custom-column {
                            margin-right: 100px;
                        }
                    </style>

                    <div class="modal fade" id="popupStore{{ $s->id }}" tabindex="-1" aria-labelledby="popupStoreLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content modal-custom">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="popupStoreLabel">Store {{ $s->store_name }} Detail</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="store-details{{ $s->id }}">
                                        <div class="row g-3">
                                            <div class="col-md-5 custom-column">
                                                <label for="name" class="form-label">Store Name</label>
                                                <input type="name" class="form-control" id="name" value="{{ $s->store_name }}" readonly>
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
                                                <input type="text" class="form-control" id="inputAddress" value="{{ $s->store_province }}" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="inputAddress2" class="form-label">Store Tokopedia</label>
                                                <input type="text" class="form-control" id="inputAddress2" value="{{ $s->store_tokopedia }}" readonly>
                                            </div>
                                            <div class="col-md-5 custom-column">
                                                <label for="inputCity" class="form-label">City</label>
                                                <input type="text" class="form-control" id="inputCity" value="{{ $s->store_city }}" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="inputAddress2" class="form-label">Store Shoope</label>
                                                <input type="text" class="form-control" id="inputAddress2" value="{{ $s->store_shoope }}" readonly>
                                            </div>
                                            <div class="col-md-5 custom-column">
                                                <label for="inputAddress" class="form-label">Store Village</label>
                                                <input type="text" class="form-control" id="inputAddress" value="{{ $s->store_village }}" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="inputAddress2" class="form-label">Store Instagram</label>
                                                <input type="text" class="form-control" id="inputAddress2" value="{{ $s->store_instagram }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </tbody>
        </table>
        @if ($store->links()->paginator->hasPages())
            <div class="d-flex justify-content-center my-4">
                {{ $store->links() }}
            </div>
        @endif
    </div>

    <script>
        function submit_approve(formId) {
            var form = document.getElementById("approvalForm" + formId);

            var confirmation = confirm("Are you sure you want to approve?");

            // Jika pengguna menyetujui
            if (confirmation) {
                form.submit();
            } else {
                // Jika pengguna membatalkan, tidak melakukan apa pun
                return false;
            }
        }

        // document.addEventListener('DOMContentLoaded', function() {
        //     const approveButtons = document.querySelectorAll('.approve-button');

        //     approveButtons.forEach(button => {
        //         button.addEventListener('click', function(event) {
        //             event.preventDefault(); // Mencegah tindakan default tombol submit

        //             const formId = button.parentElement.getAttribute('id');

        //             // Menampilkan SweetAlert
        //             Swal.fire({
        //                 title: 'Are you sure?',
        //                 text: "You won't be able to revert this!",
        //                 icon: 'warning',
        //                 showCancelButton: true,
        //                 confirmButtonColor: '#3085d6',
        //                 cancelButtonColor: '#d33',
        //                 confirmButtonText: 'Yes, approve it!'
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     // Jika pengguna menekan "Yes", kirimkan formulir
        //                     document.getElementById(formId).submit();
        //                 }
        //             });
        //         });
        //     });
        // });
    </script>

@endsection
