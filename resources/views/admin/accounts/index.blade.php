@extends('admin.layouts.admin')
@section('active-account-manage', 'active open')
@section('active-accounts', 'active')
@section('title')
    <title>Account Manage - List Accounts</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap5.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <!-- Striped Rows -->
    @include('admin.partials.content-header', ['pages' => 'Account Manage', 'name' => 'Accounts'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        @include('admin.partials.content-body', [
            'permissions_list' => 'list-accounts',
            'active_list' => 'active',
            'models' => 'Accounts',
            'url_list' => route('accounts.index'),
            'class_list' => 'bx bx-user me-1',
            'permission_create' => 'create-account',
            'active_create' => '',
            'model' => 'Account',
            'url_create' => route('accounts.create'),
            'class_create' => 'bx bx-user-plus me-1'
        ])
        @if(auth()->user()->checkPermissionAccess('delete-account') == true)
            <li class="nav-item">
                <button id="deleteAllSelectedRecord" class="btn btn-outline-danger"
                        data-url="{{ route('accounts.deleteSelected')}}">
                    <i class="bx bx-trash me-1"></i>Delete Accounts
                </button>
            </li>
        @endif
    </ul>
    <div class="card">
        <h5 class="card-header">List Accounts</h5>
        <div class="col-sm-12">
            @include('admin.partials.alert')
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="table-dataTable">
                <thead>
                <tr>
                    <th scope="col"><input type="checkbox" name="ids" class="form-check-input checkBoxAll" value="">
                    </th>
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Name</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0"></tbody>
            </table>
        </div>
    </div>
    <!--/ Striped Rows -->
@endsection
@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Script Datatable -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>
    <!--Script Datatable -->
    <script src="{{asset('admin/assets/js/index.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#table-dataTable').DataTable({
                processing: true,
                lengthChange: false,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
                ],
                ajax: {
                    type: 'get',
                    url: '/api/admin/accounts',
                },
                columns: [{
                    data: 'id',
                    'render': function (id) {
                        return '<input type="checkbox" name="ids" class="form-check-input checkBoxClass" value=' + id + '>'
                    }
                },
                    {data: "id"},
                    {data: "email"},
                    {data: "name"},
                    {
                        data: "image_path",
                        'render': function (url) {
                            if (url) return '<img class="rounded-circle" width="50" height="50" alt="" src=' + url + '>'
                            else return '<img class="rounded-circle" width="50" height="50" src={{asset('admin/assets/img/avatars/baseAvatar.png')}}>'
                        }
                    },
                    {
                        data: "status",
                        'render': function (status) {
                            if (status === 1) return '<span class="badge bg-label-primary me-1">Active</span>'
                            else return '<span class="badge bg-label-danger me-1">Block</span>'
                        }
                    },
                    {
                        data: 'id',
                        'render': function (id) {
                            return (
                                '<div class="dropdown">\
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">\
                                        <i class="bx bx-dots-vertical-rounded"></i>\
                                    </button>\
                                    <div class="dropdown-menu">\
                                        @if(auth()->user()->checkPermissionAccess('edit-account'))\
                                        <a class="dropdown-item" href=/admin/accounts/' + id + '/edit>\
                                                <i class="bx bx-edit-alt me-1"></i> Edit\
                                            </a>\
                                        \
                                        @endif\
                                        @if(auth()->user()->checkPermissionAccess('edit-account'))\
                                          <a class="dropdown-item" href=/admin/accounts/' + id + '/change-password>\
                                                <i class="bx bx-edit-alt me-1"></i> Change Password\
                                            </a>\
                                        @endif\
                                         @if(auth()->user()->checkPermissionAccess('delete-account'))\
                                            <a class="dropdown-item action_delete"\
                                                data-url="/admin/accounts/' + id + '/delete"\
                                            >\
                                                <i class="bx bx-trash me-1"></i>Delete\
                                            </a>\
                                        @endif\
                                    </div>\
                                </div>'
                            )
                        },
                    },
                ]
            });
        });
    </script>
@endsection
