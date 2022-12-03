@extends('admin.layouts.admin')
@section('active-product-manage', 'active open')
@section('active-attributes', 'active')
@section('title')
    <title>Product Manage - Update Attribute</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Striped Rows -->
    @include('admin.partials.content-header', ['pages' => 'Product Manage', 'name' => 'Attributes'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        @include('admin.partials.content-body', [
           'permissions_list' => 'list-attributes',
           'active_list' => '',
           'models' => 'Attributes',
           'url_list' => route('attributes.index'),
           'class_list' => 'bx bx-list-ul me-1',
           'permission_create' => 'create-attribute',
           'active_create' => '',
           'model' => 'Attribute',
           'url_create' => route('attributes.create'),
           'class_create' => 'bx bx-plus-circle me-1'
       ])
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);">
                <i style="font-size: 24px;" class="bx bx-edit-alt me-1"></i>Update Attribute
            </a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Update Attribute</h5>
                <hr class="my-0"/>
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <!-- Account -->
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('attributes.update', ['id'=> $attribute->id])}}"
                          method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Attribute Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{$attribute->attribute_name}}"
                                    placeholder="Enter attribute name"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Attribute Description</label>
                                <div class="input-group">
                                    <span class="input-group-text">Description</span>
                                    <textarea id="description" name="description" class="form-control"
                                              aria-label="Description" placeholder="Enter description">{{$attribute->attribute_description}}
                                    </textarea>
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="value" class="form-label">Attribute Values</label>
                                <div class="field_wrapper">
                                    @foreach($attribute->values as $value)
                                        <div class="input-group mb-3">
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="value"
                                                name="value[{!! $value->id !!}]"
                                                placeholder="Enter attribute value"
                                                value="{{$value->attribute_value_name}}"
                                            />
                                            <a id="{{$value->id}}" data-url="{{route('attributes.delete-attributeValue', ['id' => $attribute->id])}}"
                                               href="javascript:void(0);" class="delete_button btn btn-outline-primary">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                    <div class="input-group mb-3">
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="value"
                                            placeholder="Add new attribute value"
                                            disabled
                                        />
                                        <a href="javascript:void(0);" class="add_button btn btn-outline-primary">
                                            <i class="bx bx-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            const maxField = 10; //Input fields increment limitation
            const addButton = $('.add_button'); //Add button selector
            const wrapper = $('.field_wrapper'); //Input field wrapper
            const fieldHTML = '<div class="input-group mb-3"><input name="value[]" type="text" class="form-control" placeholder="Enter new attribute value"><a href="javascript:void(0);" class="remove_button btn btn-outline-primary"><i class="bx bx-minus"></i></a></div>'; //New input field html
            let x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function () {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function (e) {
                e.preventDefault();
                $(this).parent('div').remove();
            });
            //Once delete button is clicked
            $(wrapper).on('click', '.delete_button', function (e) {
                e.preventDefault();
                let urlRequest = $(this).data('url');
                const id = $(this).attr('id');
                const div = $(this).parent('div');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: 'DELETE',
                            url: urlRequest,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id: id,
                            },
                            success: function (data) {
                                div.remove(); //Remove field html
                                x--; //Decrement field counter
                                if (data.status === 'SUCCESS') {

                                    toastr.success('Delete attribute value success.', 'Success',
                                        {
                                            closeButton: true,
                                            progressBar: true,
                                            newestOnTop: true,
                                            timeOut: "3000",
                                        }
                                    )

                                }
                            },
                            error: function () {
                                toastr.error('Delete attribute value error', 'Error',
                                    {
                                        closeButton: true,
                                        progressBar: true,
                                        newestOnTop: true,
                                        timeOut: "3000",
                                    }
                                )
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection
