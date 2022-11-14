@extends('admin.layouts.admin')
@section('active-account-manage', 'active open')
@section('active-roles', 'active')
@section('title')
    <title>Account Manage - Update Role</title>
@endsection

@section('content')
    @include('admin.partials.content-header', ['pages' => 'Account Manage', 'name' => 'Roles'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{route('roles.index')}}"><i class="bx bx-shield me-1"></i> List Roles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('roles.create')}}">
                <i style="font-size: 24px;" class="bx bx-plus-circle me-1"></i>Create Role
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);">
                <i style="font-size: 24px;" class="bx bx-edit-alt me-1"></i>Update Role
            </a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Update Role</h5>
                <hr class="my-0"/>
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('roles.update', ['id' => $role->id])}}"
                          method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Role Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{$role->name}}"
                                    placeholder="Enter roles name"
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
                                    value="{{$role->display_name}}"
                                    placeholder="Enter display name"
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="parent_id" class="form-label">Permission</label>
                                <span>
                                      @foreach($permissionsParent as $permissionItem)
                                        <div class="card mb-3 col-md-12">
                                            <div class="card-header"
                                                 style="background-color: #00CCCC;
                                                 color:white; font-weight: bold; font-size: 15px;">
                                                <input
                                                    id="{{$permissionItem->id}}"
                                                    type="checkbox"
                                                    class="form-check-input checkbox_wrapper"
                                                    value="">
                                                <label for="{{$permissionItem->id}}">
                                                    Module {{$permissionItem->name}}
                                                </label>
                                            </div>
                                            <hr class="my-0"/>
                                            <div style="display: flex">
                                                @foreach($permissionItem->permissionChildren as $permissionChildrenItem)
                                                    <div class="card-body text-primary col-md-3">
                                                        <p class="card-title">
                                                            <input
                                                                {{$permissionCheck->contains('id',$permissionChildrenItem->id) ? 'checked' : ''}}
                                                                id="{{ $permissionChildrenItem->id }}"
                                                                type="checkbox" name="permission_id[]"
                                                                class="form-check-input checkbox_children"
                                                                value="{{$permissionChildrenItem->id}}">
                                                            <label for="{{$permissionChildrenItem->id }}">
                                                                {{ $permissionChildrenItem->name }}
                                                            </label>
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </span>
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
    <script>
        $('.checkbox_wrapper').on('click', function () {
            $(this).parents('div.card.mb-3.col-md-12').find('.checkbox_children').prop('checked', $(this).prop('checked'));
        });
    </script>
@endsection
