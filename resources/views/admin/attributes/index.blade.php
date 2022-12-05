@extends('admin.layouts.admin')
@section('active-product-manage', 'active open')
@section('active-attributes', 'active')
@section('title')
    <title>Product Manage - List Attributes</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap5.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <!-- Striped Rows -->
    @include('admin.partials.content-header', ['pages' => 'Product Manage', 'name' => 'Attributes'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        @include('admin.partials.content-body', [
           'permissions_list' => 'list-attributes',
           'active_list' => 'active',
           'models' => 'Attributes',
           'url_list' => route('attributes.index'),
           'class_list' => 'bx bx-list-ul me-1',
           'permission_create' => 'create-attribute',
           'active_create' => '',
           'model' => 'Attribute',
           'url_create' => route('attributes.create'),
           'class_create' => 'bx bx-plus-circle me-1'
       ])
        @if(auth()->user()->checkPermissionAccess('delete-attribute') == true)
            <li class="nav-item">
                <button id="deleteAllSelectedRecord" class="btn btn-outline-danger"
                        data-url="{{ route('attributes.deleteSelected')}}">
                    <i class="bx bx-trash me-1"></i>Delete Attributes
                </button>
            </li>
        @endif
    </ul>
    <div class="card">
        <h5 class="card-header">List Attributes</h5>
        <div class="col-sm-12">
            @include('admin.partials.alert')
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="table-dataTable">
                <thead>
                <tr>
                    <th scope="col"><input type="checkbox" name="ids" class="form-check-input checkBoxAll">
                    </th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                </tbody>
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
                    url: '/api/admin/attributes',
                },
                columns: [{
                    data: 'id',
                    'render': function (id) {
                        return '<input type="checkbox" name="ids" class="form-check-input checkBoxClass" value=' + id + '>'
                    }
                },
                    {data: "id"},
                    {data: "attribute_name"},
                    {data: "attribute_description"},
                    {
                        data: 'id',
                        'render': function (id) {
                            return (
                                '<div class="dropdown">\
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">\
                                        <i class="bx bx-dots-vertical-rounded"></i>\
                                    </button>\
                                    <div class="dropdown-menu">\
                                        @if(auth()->user()->checkPermissionAccess('edit-attribute'))\
                                        <a class="dropdown-item" href=/admin/attributes/' + id + '/edit>\
                                                <i class="bx bx-edit-alt me-1"></i> Edit\
                                            </a>\
                                        \
                                        @endif\
                                         @if(auth()->user()->checkPermissionAccess('delete-attribute'))\
                                            <a class="dropdown-item action_delete"\
                                                data-url="/admin/attributes/' + id + '/delete">\
                                                <i class="bx bx-trash me-1"></i>Delete\
                                            </a>\
                                        @endif\
                                    </div>\
                                </div>'
                            )
                        },
                    },
                ],
            });
        });
    </script>
@endsection
