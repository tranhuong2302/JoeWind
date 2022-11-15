@extends('admin.layouts.admin')
@section('active-account-manage', 'active open')
@section('active-roles', 'active')
@section('title')
    <title>Account Manage - Create Role</title>
@endsection
@section('content')
    @include('admin.partials.content-header', ['pages' => 'Account Manage', 'name' => 'Roles'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        @include('admin.partials.content-body', [
               'permissions_list' => 'list-roles',
               'active_list' => '',
               'models' => 'Roles',
               'url_list' => route('roles.index'),
               'class_list' => 'bx bx-shield me-1',
               'permission_create' => 'create-role',
               'active_create' => 'active',
               'model' => 'Role',
               'url_create' => route('roles.create'),
               'class_create' => 'bx bx-plus-circle me-1'
            ])
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Create Role</h5>
                <hr class="my-0"/>
                <div class="col-sm-12">
                    @include('admin.partials.alert')
                </div>
                <div class="card-body">
                    <form id="formAccountSettings" action="{{route('roles.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Role Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{old('name')}}"
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
                                    value="{{old('display_name')}}"
                                    placeholder="Enter display name"
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Permission</label>
                                <span>
                                      @foreach($permissionsParent as $permissionItem)
                                        <div class="card mb-3 col-md-12">
                                            <div class="card-header"
                                                 style="background-color: #00CCCC;
                                                 color:white; font-weight: bold; font-size: 15px;">
                                                <input
                                                    id="{{$permissionItem->id}}"
                                                    type="checkbox"
                                                    class="form-check-input me-2 checkbox_wrapper"
                                                    value="">
                                                <label for="{{$permissionItem->id}}">
                                                    Module {{$permissionItem->name}}
                                                </label>
                                            </div>
                                            <hr class="my-0"/>
                                            <div style="display: flex">
                                                @foreach($permissionItem->permissionChildren as $Item)
                                                    <div class="card-body text-primary col-md-3">
                                                        <p class="card-title">
                                                            <input
                                                                id="{{ $Item->id }}"
                                                                type="checkbox" name="permission_id[]"
                                                                class="form-check-input me-2 checkbox_children"
                                                                value="{{$Item->id}}">
                                                            <label for="{{ $Item->id }}">
                                                                {{ $Item->name }}
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
    <script>
        $('.checkbox_wrapper').on('click', function () {
            $(this).parents('div.card.mb-3.col-md-12').find('.checkbox_children').prop('checked', $(this).prop('checked'));
        });
    </script>
@endsection
