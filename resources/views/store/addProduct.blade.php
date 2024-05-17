@extends('layouts.main')

@section('content')
    <div class="profile-container">
        <div class="title-form d-flex align-items-left">
            <h1 style="color: white; margin-bottom: 30px;">ADD PRODUCT</h1>
        </div>
        <form id="edit-profile-form" action="" method="POST" class="d-flex flex-column" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $store->store_id }}">
            <div class="d-flex">
                <div class="add-product-form col-md-7">
                    <div class="product-detail d-flex flex-wrap justify-content-between" id="{{ $store->store_id }}">
                        <div class="col-md-12" style="padding-right: 15px;">
                            <div class="field-form">
                                <label class="label-form text-white" for="product_id">Product Category</label>
                                <div class="dropdown-wrapper">
                                    <select name="product_id" id="product_id" class="input-field form-control @error('product_id') is-invalid @enderror" required>
                                        <option value="">**Choose Product Category**</option>
                                        {{-- @foreach($provinces as $province)
                                            <option {{ $store->product_id == $province->id ? 'selected' : '' }} value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach --}}
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                    @error('product_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="mod_name">Product Name</label>
                                <input type="text" name="mod_name" id="mod_name" class="input-field form-control @error('mod_name') is-invalid @enderror" placeholder="" required value=""/>
                                @error('mod_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="description">Product Description</label>
                                <textarea name="description" id="description" class="input-field form-control @error('description') is-invalid @enderror" placeholder="" required rows="3"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="mod_price">Product Price</label>
                                <div class="input-group ">
                                    <span class="input-group-text">Rp. </span>
                                    <input type="mod_price" name="mod_price" id="mod_price" class="input-field form-control @error('mod_price') is-invalid @enderror" placeholder="" required value=""/>
                                </div>
                                @error('mod_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="mod_weight">Product Weight</label>
                                <div class="input-group">
                                    <input type="text" name="mod_weight" id="mod_weight" class="input-field form-control @error('mod_weight') is-invalid @enderror" placeholder="" required>
                                    <span class="input-group-text">Kg</span>
                                </div>
                                @error('mod_weight')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="mod_height">Product Height</label>
                                <div class="input-group">
                                    <input type="text" name="mod_height" id="mod_height" class="input-field form-control @error('mod_height') is-invalid @enderror" placeholder="" required>
                                    <span class="input-group-text">Cm</span>
                                </div>
                                @error('mod_height')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="link_tokopedia">Product Tokopedia Link</label>
                                <input type="url" name="link_tokopedia" id="link_tokopedia" class="input-field form-control @error('link_tokopedia') is-invalid @enderror" placeholder="" required value=""/>
                                @error('link_tokopedia')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="link_shopee">Product Shopee Link</label>
                                <input type="url" name="link_shopee" id="link_shopee" class="input-field form-control @error('link_shopee') is-invalid @enderror" placeholder="" required value="">
                                @error('link_shopee')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="notes">Notes</label>
                                <input type="text" name="notes" id="notes" class="input-field form-control @error('notes') is-invalid @enderror" placeholder="" required value=""/>
                                @error('notes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <table class="table-utama table table-bordered border-dark bg-white">
                            <thead>
                              <tr style="background-color: rgb(224, 224, 224);">
                                <th scope="col">No.</th>
                                <th scope="col">Car Brand</th>
                                <th scope="col">Car Model</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($store as $s)
                                    <tr>
                                        <td scope="row">{{ $loop->index + 1 }}.</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <form id="approvalForm" action="store/approval/" method="POST">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 pt-1 mb-2 d-flex justify-content-end">
                            <button id="btnSubmit" class="btn text-light" style="background-color: #F36600;" type="button">Save</button>
                        </div>
                    </div>
                </div>
                <!-- Konten upload image -->
                <div class="col-md-5 d-flex flex-column ">
                    <label for="brand_name" class="label-logo fw-bold text-white mb-3" style="margin-left: 6rem;">Upload Parts Photo</label>
                    <div class="d-flex flex-column align-items-center">
                        <input type="hidden" name="store_id" value="{{ $store->store_id }}">
                        @if($store->store_logo)
                            <img id="output" src="{{ route('store.profileImage', ['imageName' => $store->store_logo]) }}" class="logo-part rounded mb-3" alt="Image Store Profile" width="295" height="245">
                        @else
                            <img id="output" src="{{ asset('img/logo/LogoParts.jpg') }}" class="rounded mb-3" alt="Image Profile" width="295" height="245" onerror="this.onerror=null;this.src='{{ asset('img/logo/LogoParts.jpg') }}';">
                        @endif
                        <label for="myFile" class="btn btn-primary" style="background-color:#F36600; border: 0px">
                            Choose Logo
                            <input type="file" id="myFile" name="filename" class="form-control file-input @error('filename') is-invalid @enderror" onchange="previewImage(event)" accept="image/jpeg, image/png, image/jpg" style="display: none;">
                        </label>
                        @error('filename')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .input-field, .input-group-text {
            border-color: black;
        }

        .logo-part{
            border: 2px solid #F36600;
            border-radius:10px;
            background-color: rgb(97, 97, 97);
        }

        .add-product-form {
            padding: 2rem 2rem 1rem 2rem;
            margin-right: 3rem;
            background-color: rgb(83, 83, 83);
            border-radius: 5px;
            border: 2px solid rgb(214, 214, 214);
        }
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
    </script>
@endpush
