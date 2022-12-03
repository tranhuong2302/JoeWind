@extends('admin.layouts.admin')
@section('active-product-manage', 'active open')
@section('active-attributes', 'active')
@section('title')
    <title>Product Manage - Create Attribute</title>
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
           'active_create' => 'active',
           'model' => 'Attribute',
           'url_create' => route('attributes.create'),
           'class_create' => 'bx bx-plus-circle me-1'
       ])
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Create Attribute</h5>
                <hr class="my-0"/>
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('attributes.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Attribute Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{old('name')}}"
                                    placeholder="Enter attribute name"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Attribute Description</label>
                                <div class="input-group">
                                    <span class="input-group-text">Description</span>
                                    <textarea id="description" name="description" class="form-control"
                                              aria-label="Description" placeholder="Enter description"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="value" class="form-label">Attribute Values</label>
                                <div class="field_wrapper">
                                    <div class="input-group mb-3">
                                        <input
                                            class="form-control"
                                            type="text"
                                            id="value"
                                            name="value[]"
                                            placeholder="Enter attribute value"
                                        />
                                        <a href="javascript:void(0);" class="add_button btn btn-outline-primary">
                                            <i class="bx bx-plus"></i>
                                        </a>
                                    </div>
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
    <script type="text/javascript">
        $(document).ready(function () {
            const maxField = 10; //Input fields increment limitation
            const addButton = $('.add_button'); //Add button selector
            const wrapper = $('.field_wrapper'); //Input field wrapper
            const fieldHTML = '<div class="input-group mb-3"><input name="value[]" type="text" class="form-control" placeholder="Enter attribute value"><a href="javascript:void(0);" class="remove_button btn btn-outline-primary"><i class="bx bx-minus"></i></a></div>'; //New input field html
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
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>
@endsection
