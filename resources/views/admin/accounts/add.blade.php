@extends('admin.layouts.admin')
@section('active-account-manage', 'active open')
@section('active-accounts', 'active')
@section('title')
    <title>Account Manage - Create Account</title>
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
    @include('admin.partials.content-header', ['pages' => 'Account Manage', 'name' => 'Accounts'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        @include('admin.partials.content-body', [
            'permissions_list' => 'list-accounts',
            'active_list' => '',
            'models' => 'Accounts',
            'url_list' => route('accounts.index'),
            'class_list' => 'bx bx-user me-1',
            'permission_create' => 'create-account',
            'active_create' => 'active',
            'model' => 'Account',
            'url_create' => route('accounts.create'),
            'class_create' => 'bx bx-user-plus me-1'
            ])
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
                                <div class="input-group">
                                    <span  class="input-group-text"><i class="bx bx-user"></i></span>
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

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="email"
                                        name="email"
                                        value="{{old('email')}}"
                                        placeholder="Enter your email"
                                    />
                                    <span class="input-group-text">@example.com</span>
                                </div>

                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                <div class="input-group">
                                    <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
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
                                <label for="floatingSelect2" class="form-label">Roles</label>
                                <select name="role_id[]" id="floatingSelect2" class="form-control selectRoles"
                                        multiple="multiple">
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $(".selectRoles").select2({
                placeholder: "Select Roles",
                tokenSeparators: [',', ' ']
            });
        })
    </script>
@endsection
