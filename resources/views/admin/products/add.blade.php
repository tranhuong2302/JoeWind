@extends('admin.layouts.admin')
@section('active-product-manage', 'active open')
@section('active-products', 'active')
@section('title')
    <title>Product Manage - Create Product</title>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .select2-selection__choice {
            background-color: #0c525d !important;
            color: white;
        }
    </style>
@endsection
@section('content')
    <!-- Striped Rows -->
    @include('admin.partials.content-header', ['pages' => 'Product Manage', 'name' => 'Products'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        @include('admin.partials.content-body', [
            'permissions_list' => 'list-products',
            'active_list' => '',
            'models' => 'Products',
            'url_list' => route('products.index'),
            'class_list' => 'bx bxl-product-hunt me-1',
            'permission_create' => 'create-product',
            'active_create' => 'active',
            'model' => 'Product',
            'url_create' => route('products.create'),
            'class_create' => 'bx bx-plus-circle me-1'
        ])
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Create Product</h5>
                <hr class="my-0"/>
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <!-- Account -->
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('products.store')}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Product name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{old('name')}}"
                                    placeholder="Enter product name"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="category_id" class="form-label">Category</label>
                                <select multiple="multiple" id="category_id" class="form-control selectCategories"
                                        name="category_id[]">
                                    {!! $htmlOptions !!}
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input
                                    class="form-control"
                                    type="number"
                                    id="price"
                                    name="price"
                                    min="0"
                                    value="{{old('price')}}"
                                    placeholder="Enter price"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="discount">Discount</label>
                                <input
                                    type="number"
                                    id="discount"
                                    name="discount"
                                    min="0"
                                    max="100"
                                    value="{{old('discount')}}"
                                    class="form-control"
                                    placeholder="Enter discount"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="attribute" class="form-label">Attribute</label>
                                <select id="attribute" class="select2 form-select selectAttribute">
                                    <option>Select Attribute</option>
                                    @foreach($attributes as $attribute)
                                        <option data-url="{{route('attributes.values', ['id' => $attribute->id])}}"
                                                value="{{$attribute->id}}">{{$attribute->attribute_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="attribute_value" class="form-label">Attribute values</label>
                                <select multiple="multiple" id="attribute_value"
                                        class="form-control selectAttributeValue" name="attribute_value[]">
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="inputGroupFile02">Product Images</label>
                                <div class="input-group">
                                    <input multiple type="file" name="image_path[]" class="form-control"
                                           id="inputGroupFile02">
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                                <div class="filearray d-block">
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" placeholder="Enter description"></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-check-inline mt-3">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="status"
                                        id="active"
                                        value="1"
                                        checked
                                    />
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="status"
                                        id="block"
                                        value="0"
                                    />
                                    <label class="form-check-label" for="block">Block</label>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label d-block">Is Feature?</label>
                                <div class="form-check form-check-inline mt-3">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_feature"
                                        id="on"
                                        value="1"
                                        checked
                                    />
                                    <label class="form-check-label" for="on">On</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_feature"
                                        id="off"
                                        value="0"
                                    />
                                    <label class="form-check-label" for="off">Off</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Create</button>
                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/of79izwrwc7h3ybvvp7pozd3dbz3m5y1oizh42h7h8zf4lsv/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            /* enable title field in the Image dialog*/
            image_title: true,
            /* enable automatic uploads of images represented by blob or data URIs*/
            automatic_uploads: true,
            /*
              URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
              images_upload_url: 'postAcceptor.php',
              here we add custom filepicker only to Image dialog
            */
            file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback: (cb, value, meta) => {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];

                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        /*
                          Note: Now we need to register the blob in TinyMCEs image blob
                          registry. In the next release this part hopefully won't be
                          necessary, as we are looking to handle it internally.
                        */
                        const id = 'blobid' + (new Date()).getTime();
                        const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(',')[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), { title: file.name });
                    });
                    reader.readAsDataURL(file);
                });

                input.click();
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
    <script>
        $(function () {
            $(".selectCategories").select2({
                placeholder: "Select Category",
                tokenSeparators: [',', ' ']
            });
            $(".selectAttributeValue").select2({
                placeholder: "Select Attribute Values",
                tokenSeparators: [',', ' ']
            });
            $("#inputGroupFile02").on('change', function () {
                $(".filearray").empty();//you can remove this code if you want previous user input
                for (let i = 0; i < this.files.length; ++i) {
                    let filereader = new FileReader();
                    let $img = jQuery.parseHTML("<img src='' alt='' class='m-3' width='100px' height='100px'>");
                    filereader.onload = function () {
                        $img[0].src = this.result;
                    };
                    filereader.readAsDataURL(this.files[i]);
                    $(".filearray").append($img);
                }
            });
            $(".selectAttribute").change(function () {
                let id = $(this).val();
                let url = $(this).children(":selected").attr('data-url');
                let htmlOptions = $(this).parents('div.row');
                let options = "";
                htmlOptions.find("select.selectAttributeValue").html(" ");
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {
                        'id': id,
                    },
                    success: function (response) {
                        if (response.status === "SUCCESS") {
                            response.data.forEach(function (data) {
                                options += "<option value=" + data.id + ">" + data.attribute_value_name + "</option>"
                            });
                            htmlOptions.find("select.selectAttributeValue").html(" ");
                            htmlOptions.find("select.selectAttributeValue").append(options);
                        }
                    }
                })
            })
        })
    </script>
@endsection
