@extends('admin.layouts.admin')
@section('active-account-manage', 'active open')
@section('active-permission', 'active')
@section('title')
    <title>Account Manage - Update Permissions</title>
@endsection

@section('content')
    @include('admin.partials.content-header', ['pages' => 'Account Manage', 'name' => 'Permissions'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        @include('admin.partials.content-body', [
               'permissions_list' => 'list-permissions',
               'active_list' => '',
               'models' => 'Permissions',
               'url_list' => route('permissions.index'),
               'class_list' => 'bx bx-list-ul me-1',
               'permission_create' => 'create-permission',
               'active_create' => '',
               'model' => 'Permission',
               'url_create' => route('permissions.create'),
               'class_create' => 'bx bx-plus-circle me-1'
            ])
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);">
                <i style="font-size: 24px;" class="bx bx-edit-alt me-1"></i>Update Permissions
            </a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Update Permission</h5>
                <hr class="my-0"/>
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <!-- Account -->
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('permissions.update', ['id'=> $permission->id])}}"
                          method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Permission Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{$permission->name}}"
                                    placeholder="Enter permission name"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="display_name" class="form-label">Display Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="display_name"
                                    name="display_name"
                                    value="{{$permission->display_name}}"
                                    placeholder="Enter display name"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="parent_id" class="form-label">Permission Father</label>
                                <select id="parent_id" class="select2 form-select" name="parent_id">
                                    <option value="0">Select Permission Father</option>
                                    {!! $htmlOptions !!}
                                </select>
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
