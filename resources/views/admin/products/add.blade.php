@extends('admin.layouts.admin')
@section('active-product-manage', 'active open')
@section('active-products', 'active')
@section('title')
    <title>Product Manage - Create Product</title>
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
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <!-- Account -->
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('products.store')}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
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
                                <label for="userName" class="form-label">Username</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="userName"
                                    name="name"
                                    value="{{old('name')}}"
                                    placeholder="Enter your username"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="email"
                                    name="email"
                                    value="{{old('email')}}"
                                    placeholder="Enter your email"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="text"
                                        id="phoneNumber"
                                        name="phone"
                                        value="{{old('phone')}}"
                                        class="form-control"
                                        placeholder="090 670 4847"
                                    />
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                       value="{{old('address')}}"
                                       placeholder="Address"/>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="floatingSelect2" class="form-label">Roles</label>
                                <select name="role_id[]" id="floatingSelect2" class="form-control selectRoles"
                                        multiple="multiple">
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label pe-2">Status</label>
                                <div class="btn-group" role="group">
                                    <input
                                        type="radio"
                                        name="status"
                                        id="radioActive"
                                        checked
                                        value="1"
                                    />
                                    <label class="pe-3" for="radioActive">Active</label>
                                    <input type="radio" name="status" id="radioBlock" value="0"/>
                                    <label for="radioBlock">Block</label>
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
    <!-- Page JS -->
    <script src="{{asset('admin/assets/js/pages-account-settings-account.js')}}"></script>
@endsection
