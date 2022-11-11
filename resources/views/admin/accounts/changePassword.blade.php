@extends('admin.layouts.admin')
@section('active-account-manage', 'active open')
@section('active-accounts', 'active')
@section('title')
    <title>Account Manage - Change Password Account</title>
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
                <i style="font-size: 24px;" class="bx bx-edit me-1"></i>Change Password Account
            </a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Change Password Account</h5>
                <hr class="my-0 mt-1 mb-1"/>
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <!-- Account -->
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('accounts.updatepassword', ['id' => $currentId])}}"
                          method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="password" class="form-label">Old Password</label>
                                <input
                                    class="form-control"
                                    type="password"
                                    id="password"
                                    name="oldpassword"
                                    placeholder="Enter old password"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="new_Password" class="form-label">New Password</label>
                                <input
                                    class="form-control"
                                    type="password"
                                    id="new_Password"
                                    name="newpassword"
                                    placeholder="Enter new password"
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="confirm_Password" class="form-label">Confirm Password</label>
                                <input
                                    class="form-control"
                                    type="password"
                                    id="confirm_Password"
                                    name="confirmpassword"
                                    placeholder="Enter confirm password"
                                />
                            </div>
                            <span id='message'></span>
                        </div>
                        <div class="mt-2">
                            <button id="submit-button" type="submit" class="btn btn-primary me-2">Save Changes</button>
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
    <script>
        $('#new_Password, #confirm_Password').on('keyup', function () {
            if ($('#new_Password').val() !== $('#confirm_Password').val()) {
                $('#message').html('Not Matching').css('color', 'red');
                $('#submit-button').prop('disabled', true);
            } else {
                $('#message').html('Matching').css('color', 'green');
                $('#submit-button').prop('disabled', false);
            }
        });
    </script>
@endsection
