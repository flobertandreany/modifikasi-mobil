@extends('layouts.main')

@section('content')
        <div class="d-flex">
            <a href="{{ route('store.productList') }}" class="btn-back"><i class="fa fa-arrow-left fa-2x"></i></a>
            <h1 style="color: white; margin-bottom: 30px; margin-left: 1rem;">EDIT PRODUCT</h1>
        </div>
        <form class="product-form" id="editProductForm" action="{{ route('store.updateProduct', ['id' => $products->product_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="store_id" value="{{ $store->store_id }}">
            <div class="d-flex">
                <div class="product-form-container col-md-9">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="col-md-12" style="padding-right: 15px;">
                            <div class="field-form">
                                <input type="hidden" name="product_category" value="{{ $product_category_id }}">
                                <label class="label-form text-white" for="product_category_id">Product Category</label>
                                <div class="dropdown-wrapper">
                                    <select name="product_category_id" id="product_category_id" class="input-field form-control" disabled>
                                        <option value="">**Choose Product Category**</option>
                                        <option value="1" {{ $product_category_id == 1 ? 'selected' : '' }}>Spare Part</option>
                                        <option value="2" {{ $product_category_id == 2 ? 'selected' : '' }}>Modification</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="product_subcategory_id">Product Subcategory</label>
                                <div class="dropdown-wrapper">
                                    <select name="product_subcategory_id" id="product_subcategory_id" class="input-field form-control">
                                        <option value="">**Choose Product Subcategory**</option>
                                        @foreach ($product_subcategory as $subcategory)
                                            <option {{ $products->product_subcategory_id == $subcategory->id ? 'selected' : '' }} value="{{ $subcategory->id }}">{{ $subcategory->product_name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down select-icon"></i>
                                </div>
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="name">Product Name</label>
                                <input type="text" name="name" id="name" class="input-field form-control" placeholder="" value="{{ $products->name }}"/>
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="description">Product Description</label>
                                <textarea name="description" id="description" class="input-field form-control" placeholder="" rows="3">{{ $products->description }}</textarea>
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="price">Product Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp. </span>
                                    <input type="text" name="price" id="price" class="input-field form-control" placeholder="" value="{{ $products->price }}"/>
                                </div>
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="weight">Product Weight</label>
                                <div class="input-group">
                                    <input type="text" name="weight" id="weight" class="input-field form-control" placeholder="" value="{{ $products->weight }}">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="height">Product Height</label>
                                <div class="input-group">
                                    <input type="text" name="height" id="height" class="input-field form-control" placeholder="" value="{{ $products->height }}">
                                    <span class="input-group-text">Cm</span>
                                </div>
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="link_tokopedia">Product Tokopedia Link</label>
                                <input type="url" name="link_tokopedia" id="link_tokopedia" class="input-field form-control" placeholder="" value="{{ $products->link_tokopedia }}"/>
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="link_shopee">Product Shopee Link</label>
                                <input type="url" name="link_shopee" id="link_shopee" class="input-field form-control" placeholder="" value="{{ $products->link_shopee }}">
                            </div>
                            <div class="field-form">
                                <label class="label-form text-white" for="notes">Notes</label>
                                <input type="text" name="notes" id="notes" class="input-field form-control" placeholder="" value="{{ $products->notes }}"/>
                            </div>
                        </div>
                        <table id="add-product-table" class="table-utama table table-bordered border-dark bg-white">
                            <thead>
                              <tr style="background-color: rgb(224, 224, 224);">
                                <th scope="col">No.</th>
                                <th scope="col">Car Brand</th>
                                <th scope="col">Car Model</th>
                                <th scope="col">Car Year</th>
                                <th scope="col">Car Engine</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_details as $p_detail)
                                    <tr>
                                        <td scope="row" style="width: 5%;">{{ $loop->index + 1 }}.</td>
                                        <td style="width: 20%;">
                                            <div class="dropdown-wrapper">
                                                <select name="car_brand_id-{{ $loop->index + 1 }}" id="car_brand_id" class="input-field form-control">
                                                    <option value="">**Choose Car Brand**</option>
                                                    @foreach($car_brand as $brand)
                                                        <option {{ $p_detail->car_brand_id == $brand->id ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->car_brand_name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fas fa-chevron-down select-icon"></i>
                                            </div>
                                        </td>
                                        <td style="width: 20%;">
                                            <div class="dropdown-wrapper">
                                                <select name="car_model_id-{{ $loop->index + 1 }}" id="car_model_id" class="input-field form-control" >
                                                    <option value="">**Choose Car Model**</option>
                                                    @foreach($p_detail->all_car_model as $model)
                                                        <option {{ $p_detail->car_model_name == $model->car_model_name ? 'selected' : '' }} value="{{ $model->car_model_name }}">{{ $model->car_model_name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fas fa-chevron-down select-icon"></i>
                                            </div>
                                        </td>
                                        <td style="width: 15%;">
                                            <div class="dropdown-wrapper">
                                                <select name="car_year-{{ $loop->index + 1 }}" id="car_year" class="input-field form-control" >
                                                    <option value="">**Choose Car Year**</option>
                                                    @foreach($p_detail->all_car_year as $year)
                                                        <option {{ $p_detail->car_year == $year->car_year ? 'selected' : '' }} value="{{ $year->car_year }}">{{ $year->car_year }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fas fa-chevron-down select-icon"></i>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="dropdown-wrapper">
                                                <select name="car_engine_id-{{ $loop->index + 1 }}" id="car_engine_id" class="input-field form-control" >
                                                    <option value="">**Choose Car Engine**</option>
                                                    {{-- <option {{ $p_detail->car_engine_id ? 'selected' : '' }} value="{{ $p_detail->car_engine_id }}">{{ $p_detail->car_engine_name }}</option> --}}
                                                    @foreach($p_detail->all_car_engine as $engine)
                                                        <option {{ $p_detail->car_engine_name == $engine->engine_name ? 'selected' : '' }} value="{{ $p_detail->car_engine_id }}">{{ $engine->engine_name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fas fa-chevron-down select-icon"></i>
                                            </div>
                                        </td>
                                        <td style="width: 10%;">
                                            <button class="btn btn-sm text-light" type="button" onclick="addRow()" style="background-color: #F36600;">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            <button class="btn btn-sm text-light" type="button" onclick="deleteRow(this)" style="background-color: #FF0000;">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 pt-1 mb-2 d-flex justify-content-end">
                            <button id="btnSubmitProduct" class="btn text-light" style="background-color: #F36600;" type="button">Save</button>
                        </div>
                    </div>
                </div>
                <!-- Konten upload image -->
                <div class="image-container">
                    <label class="label-logo fw-bold text-white mb-3">Upload Part Photo</label>
                    <div class="image-product-container">
                        @if($products->image)
                            <img id="imgProduct" src="{{ route('store.productImage', ['imageName' => $products->image]) }}" class="rounded image-product" alt="Image Product" width="295" height="245">
                        @else
                            <img id="imgProduct" src="{{ asset('img/logo/LogoParts.jpg') }}" class="rounded image-product" alt="Image Product" width="295" height="245" onerror="this.onerror=null;this.src='{{ asset('img/logo/LogoParts.jpg') }}';">
                        @endif
                    </div>
                    <div style="text-align: center;">
                        <label for="image_product" class="btn btn-primary mt-3" style="background-color:#F36600; border: 0px">
                            Choose Logo
                            <input type="file" id="image_product" name="image_product" class="form-control file-input" onchange="previewImageProduct(event)" accept="image/jpeg, image/png, image/jpg" style="display: none;">
                        </label>
                    </div>
                </div>
            </div>
        </form>
@endsection
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .input-field, .input-group-text {
            border-color: black;
        }

        .image-product{
            border: 3px solid #F36600;
        }
    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        const defaultImgSrc = $('#imgProduct').attr('src');

        $('#product_category_id').change(function() {
            $('#product_subcategory_id').empty().append('<option value="">**Choose Subcategory**</option>');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                },
                url: '{{ route('store.getSubcategory') }}',
                method: 'GET',
                dataType: 'json',
                data: {
                    id: $(this).val()
                },
                success: function(data) {
                    data.forEach(function(subcategory) {
                        $('#product_subcategory_id').append('<option value="' + subcategory.id + '">' + subcategory.product_name + '</option>');
                    });
                }
            });
        });

        function previewImageProduct(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var img = document.getElementById('imgProduct');
                img.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function addRow() {
            const tableBody = $('#add-product-table tbody');
            const rowCount = tableBody.children('tr').length;
            const newRow = `
                <tr>
                    <td scope="row" style="width: 5%;">${rowCount + 1}.</td>
                    <td style="width: 20%;">
                        <div class="dropdown-wrapper">
                            <select name="car_brand_id-${rowCount + 1}" id="car_brand_id" class="input-field form-control">
                                <option value="">**Choose Car Brand**</option>
                                @foreach($car_brand as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->car_brand_name }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </td>
                    <td style="width: 20%;">
                        <div class="dropdown-wrapper">
                            <select name="car_model_id-${rowCount + 1}" id="car_model_id" class="input-field form-control">
                                <option value="">**Choose Car Model**</option>
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </td>
                    <td style="width: 15%;">
                        <div class="dropdown-wrapper">
                            <select name="car_year-${rowCount + 1}" id="car_year" class="input-field form-control">
                                <option value="">**Choose Car Year**</option>
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </td>
                    <td style="width: 25%;">
                        <div class="dropdown-wrapper">
                            <select name="car_engine_id-${rowCount + 1}" id="car_engine_id" class="input-field form-control">
                                <option value="">**Choose Car Engine**</option>
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </td>
                    <td style="width: 10%;">
                        <button class="btn btn-sm text-light" type="button" onclick="addRow()" style="background-color: #F36600;">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button class="btn btn-sm text-light" type="button" onclick="deleteRow(this)" style="background-color: #FF0000;">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;

            tableBody.append(newRow);
        }

        function deleteRow(button) {
            var tableRow = $(button).closest('tr');
            var tableBody = tableRow.parent();
            var rowCount = tableBody.children('tr').length;
            if (rowCount > 1) {
                tableRow.remove();

                $('#add-product-table tbody tr').each(function(index, row) {
                    $(row).find('td:first').text((index + 1) + '.');

                    $(row).find('select').each(function() {
                        const nameAttr = $(this).attr('name');
                        const newNameAttr = nameAttr.replace(/-\d+$/, `-${index + 1}`);
                        $(this).attr('name', newNameAttr);
                    });

                    $(row).find('.error-message').each(function() {
                        const errorText = $(this).text();
                        const updatedErrorText = errorText.replace(/-\d+/g, `-${index + 1}`);
                        $(this).text(updatedErrorText);
                    });
                });
            }
        }


        $(document).on('change', '#car_brand_id', function() {
            const $carModel = $(this).closest('tr').find('#car_model_id');
            const $carYear = $(this).closest('tr').find('#car_year');
            const $carEngine = $(this).closest('tr').find('#car_engine_id');

            $carModel.empty().append('<option value="">**Choose Car Model**</option>');
            $carYear.empty().append('<option value="">**Choose Car Year**</option>');
            $carEngine.empty().append('<option value="">**Choose Car Engine**</option>');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('store.getCarModel') }}',
                method: 'GET',
                dataType: 'json',
                data: {
                    id: $(this).val()
                },
                success: function(data) {
                    data.forEach(function(model) {
                        $carModel.append('<option value="' + model.car_model_name + '">' + model.car_model_name + '</option>');
                    });
                }
            });
        });

        $(document).on('change', '#car_model_id', function() {
            const $carYear = $(this).closest('tr').find('#car_year');
            const $carEngine = $(this).closest('tr').find('#car_engine_id');

            $carYear.empty().append('<option value="">**Choose Car Year**</option>');
            $carEngine.empty().append('<option value="">**Choose Car Engine**</option>');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('store.getCarYear') }}',
                method: 'GET',
                dataType: 'json',
                data: {
                    car_model_name: $(this).val()
                },
                success: function(data) {
                    data.forEach(function(model) {
                        $carYear.append('<option value="' + model.car_year + '">' + model.car_year + '</option>');
                    });
                }
            });
        });

        $(document).on('change', '#car_year', function() {
            const $carModel = $(this).closest('tr').find('#car_model_id').val();
            const $carEngine = $(this).closest('tr').find('#car_engine_id');

            $carEngine.empty().append('<option value="">**Choose Car Engine**</option>');
            console.log($carModel);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('store.getCarEngine') }}',
                method: 'GET',
                dataType: 'json',
                data: {
                    car_year: $(this).val(),
                    car_model_name: $carModel
                },
                success: function(data) {
                    data.forEach(function(engine) {
                        $carEngine.append('<option value="' + engine.id + '">' + engine.engine_name + '</option>');
                    });
                }
            });
        });

        $('#btnSubmitProduct').click(function(){
            Swal.fire({
                title: 'Are you sure you want to update this Product?',
                text: 'This will update this product, and you cannot undo this action.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#19B400',
                cancelButtonColor: '#FFFFFF',
                confirmButtonText: 'Approve',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'confirm-button-swal',
                    cancelButton: 'cancel-button-swal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#editProductForm').submit();
                }
            });
        });

        $('#editProductForm').submit(function(event) {
            event.preventDefault();
            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                processData: false, // Jangan proses data karena sudah dalam bentuk FormData
                contentType: false, // Jangan set contentType, biarkan browser yang mengatur
                success: function(response) {
                    if (response.success) {
                        window.location.href = '/store';
                    }
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    console.log(errors);
                    const tableBody = $('#add-product-table tbody');
                    const rowCount = tableBody.children('tr').length;

                    if (errors) {
                        $('.error-message').remove();
                        // Menampilkan error message
                        for (var fieldName in errors) {
                            var fieldErrors = errors[fieldName];
                            var errorMessage = fieldErrors.join(', ');
                            var $field = $('[name="' + fieldName + '"]');
                            var $inputGroup = $field.closest('.input-group');

                            if ($inputGroup.length > 0) {
                                $inputGroup.addClass('is-invalid').after('<div class="error-message">' + errorMessage + '</div>');
                            } else if (fieldName == 'image_product') {
                                var img = $('#imgProduct');
                                console.log(img.attr('src') == defaultImgSrc);
                                if (img.attr('src') == defaultImgSrc) {
                                    img.after('<div class="error-message text-danger">' + errorMessage + '</div>');
                                }
                            } else {
                                $field.addClass('is-invalid').after('<div class="error-message">' + errorMessage + '</div>');
                            }
                        }
                        var firstErrorField = Object.keys(errors)[0];
                        $('[name="' + firstErrorField + '"]').focus();
                        $('.is-invalid').on('input', function() {
                            $(this).removeClass('is-invalid');
                            $(this).next('.error-message').remove();
                        });
                    }
                }
            });
        });
    </script>
@endpush
