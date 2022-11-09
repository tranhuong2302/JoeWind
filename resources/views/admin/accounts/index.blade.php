@extends('admin.layouts.admin')
@section('active-account-manage', 'active open')
@section('active-accounts', 'active')
@section('title')
    <title>Account Manage - List Accounts</title>
@endsection
@section('content')
    <!-- Striped Rows -->
    @include('admin.partials.content-header', ['pages' => 'Account Manage', 'name' => 'Accounts'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> List Accounts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('account.create')}}"><i style="font-size: 24px;"
                                                                      class="bx bx-user-plus me-1"></i>
                Create Account</a>
        </li>
    </ul>
    <div class="card">
        <h5 class="card-header">List Accounts</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col"><input type="checkbox" name="ids" class="form-check-input checkBoxAll" value="">
                    </th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @if($accounts->count() == 0)
                    <tr>
                        <td colspan="7" class="text-center"><strong>No data to display</strong></td>
                    </tr>
                @elseif($accounts->count() != 0)
                    @foreach($accounts as $account)
                        <tr id="sid{{$account->id}}">
                            <td><input type="checkbox" name="ids" class="form-check-input checkBoxClass"
                                       value="{{$account->id}}"></td>
                            <td>{{$account->id}}</td>
                            <td>{{$account->name}}</td>
                            <td><strong>{{$account->email}}</strong></td>
                            <td>
                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="{{$account->name}}">
                                        <img width="100px" height="100px" src="{{$account->image_path}}"
                                             alt="{{$account->image_name}}" class="rounded-circle"/>
                                    </li>
                                </ul>
                            <td>
                                @if($account->status == 1)
                                    <span class="badge bg-label-primary me-1">Active</span>
                                @elseif($account->status == 0)
                                    <span class="badge bg-label-danger me-1">Block</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-edit-alt me-1"></i>
                                            Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-trash me-1"></i>
                                            Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong></td>
                    <td>Albert Cook</td>
                    <td>
                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle"/>
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle"/>
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                class="avatar avatar-xs pull-up" title="Christina Parker">
                                <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle"/>
                            </li>
                        </ul>
                    </td>
                    <td><span class="badge bg-label-primary me-1">Active</span></td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>
                                    Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                    Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Striped Rows -->
@endsection
