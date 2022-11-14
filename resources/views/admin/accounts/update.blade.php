@extends('admin.layouts.admin')
@section('active-account-manage', 'active open')
@section('active-accounts', 'active')
@section('title')
    <title>Account Manage - Update Account</title>
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
        <li class="nav-item">
            <a class="nav-link" href="{{route('accounts.index')}}"><i class="bx bx-user me-1"></i> List Accounts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('accounts.create')}}">
                <i style="font-size: 24px;" class="bx bx-user-plus me-1"></i>Create Account
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);">
                <i style="font-size: 24px;" class="bx bxs-user-detail me-1"></i>Update Account
            </a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Update Account</h5>
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <!-- Account -->
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('accounts.update', ['id' => $account->id])}}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img
                                src="{{$account->image_path}}"
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
                                    value="{{$account->name}}"
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
                                    value="{{$account->email}}"
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
                                        value="{{$account->phone}}"
                                        class="form-control"
                                        placeholder="090 670 4847"
                                    />
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                       value="{{$account->address}}"
                                       placeholder="Address"/>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="floatingSelect2" class="form-label">Roles</label>
                                <select name="role_id[]" id="floatingSelect2" class="form-control selectRoles"
                                        multiple="multiple">
                                    @foreach($roles as $role)
                                        <option {{$rolesOfUser->contains('id', $role->id) ? 'selected' : ''}}
                                            value="{{$role->id}}">{{$role->name}}</option>
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
                                        {{$account->status == 1 ? 'checked' : ''}}
                                    />
                                    <label class="pe-3" for="radioActive">Active</label>
                                    <input type="radio" name="status" id="radioBlock"
                                           value="0" {{$account->status == 0 ? 'checked' : ''}}/>
                                    <label for="radioBlock">Block</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save Changes</button>
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
                tags: true,
                tokenSeparators: [',', ' ']
            });
        })
    </script>
@endsection
