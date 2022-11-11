@extends('admin.layouts.admin')
@section('active-account-manage', 'active open')
@section('active-accounts', 'active')
@section('title')
    <title>Account Manage - Create Account</title>
@endsection
@section('content')
    @include('admin.partials.content-header', ['pages' => 'Account Manage', 'name' => 'Accounts'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{route('accounts.index')}}"><i class="bx bx-user me-1"></i> List Accounts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{route('accounts.create')}}">
                <i style="font-size: 24px;" class="bx bx-user-plus me-1"></i>Create Account
            </a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Create Account</h5>
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <!-- Account -->
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('accounts.store')}}" method="POST"
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
                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" class="select2 form-select" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Create</button>
                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- Page JS -->
    <script src="{{asset('admin/assets/js/pages-account-settings-account.js')}}"></script>
@endsection
