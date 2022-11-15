@extends('admin.layouts.admin')
@section('active-product-manage', 'active open')
@section('active-categories', 'active')
@section('title')
    <title>Product Manage - Update Category</title>
@endsection
@section('content')
    <!-- Striped Rows -->
    @include('admin.partials.content-header', ['pages' => 'Product Manage', 'name' => 'Categories'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        @include('admin.partials.content-body', [
           'permissions_list' => 'list-categories',
           'active_list' => '',
           'models' => 'Categories',
           'url_list' => route('categories.index'),
           'class_list' => 'bx bx-category-alt me-1',
           'permission_create' => 'create-category',
           'active_create' => '',
           'model' => 'Category',
           'url_create' => route('categories.create'),
           'class_create' => 'bx bx-plus-circle me-1'
       ])
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);">
                <i style="font-size: 24px;" class="bx bx-edit-alt me-1"></i>Update Category
            </a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Update Category</h5>
                <hr class="my-0"/>
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <!-- Account -->
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('categories.update', ['id' => $category->id])}}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img
                                src="{{asset('admin/assets/img/avatars/baseAvatar.png')}}"
                                alt="user-avatar"
                                class="d-block rounded"
                                height="100"
                                width="100"
                                id="uploadedAvatar"
                            />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input
                                        type="file"
                                        id="upload"
                                        class="account-file-input"
                                        name="image_path"
                                        hidden
                                        accept="image/png, image/jpeg"
                                    />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>
                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                        <hr class="my-0 mt-3 mb-3"/>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Category Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{$category->name}}"
                                    placeholder="Enter Category name"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="parent_id" class="form-label">Category Father</label>
                                <select id="parent_id" class="select2 form-select" name="parent_id">
                                    <option value="0">Select Category Father</option>
                                    {!! $htmlOptions !!}
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Category Description</label>
                                <div class="input-group">
                                    <span class="input-group-text">Description</span>
                                    <textarea id="description" name="description" class="form-control"
                                              aria-label="Description" placeholder="Enter description">{{$category->description}}
                                    </textarea>
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
    <!-- Page JS -->
    <script src="{{asset('admin/assets/js/pages-account-settings-account.js')}}"></script>
@endsection
