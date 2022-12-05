@extends('admin.layouts.admin')
@section('active-product-manage', 'active open')
@section('active-products', 'active')
@section('title')
    <title>Product Manage - List Products</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap5.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <!-- Striped Rows -->
    @include('admin.partials.content-header', ['pages' => 'Product Manage', 'name' => 'Products'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        @include('admin.partials.content-body', [
            'permissions_list' => 'list-products',
            'active_list' => 'active',
            'models' => 'Products',
            'url_list' => route('products.index'),
            'class_list' => 'bx bxl-product-hunt me-1',
            'permission_create' => 'create-product',
            'active_create' => '',
            'model' => 'Product',
            'url_create' => route('products.create'),
            'class_create' => 'bx bx-plus-circle me-1'
        ])
        @if(auth()->user()->checkPermissionAccess('delete-product') == true)
            <li class="nav-item">
                <button id="deleteAllSelectedRecord" class="btn btn-outline-danger"
                        data-url="{{ route('products.deleteSelected')}}">
                    <i class="bx bx-trash me-1"></i>Delete Products
                </button>
            </li>
        @endif
    </ul>
    <div class="card">
        <h5 class="card-header">List Products</h5>
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
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Price</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Feature</th>
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
                responsive: true,
                lengthChange: false,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
                ],
                ajax: {
                    type: 'get',
                    url: '/api/admin/products',
                },
                columns: [{
                    data: "id",
                    'render': function (id) {
                        return '<input type="checkbox" name="ids" class="form-check-input checkBoxClass" value=' + id + '>'
                    }
                },
                    {data: "id"},
                    {data: "name", width: '50px'},
                    {
                        data: "image_path",
                        'render': function (url) {
                            if (url) return '<img class="rounded-circle" width="50" height="50" src=' + url + '>'
                            else return '<img class="rounded-circle" width="50" height="50" src={{asset('admin/assets/img/avatars/baseAvatar.png')}}>'
                        }
                    },
                    {
                        data: "price",
                        'render': function (price) {
                            return new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(price);
                        }
                    },
                    {data: "discount"},
                    {
                        data: "status",
                        'render': function (status) {
                            if (status === 1) return '<span class="badge bg-label-primary me-1">Active</span>'
                            else return '<span class="badge bg-label-danger me-1">Block</span>'
                        }
                    },
                    {
                        data: "is_feature",
                        'render': function (status) {
                            if (status === 1) return '<span class="badge bg-label-info me-1">On</span>'
                            else return '<span class="badge bg-label-warning me-1">Off</span>'
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
                                        @if(auth()->user()->checkPermissionAccess('edit-product'))\
                                            <a class="dropdown-item" href=/admin/products/' + id + '/edit>\
                                                <i class="bx bx-edit-alt me-1"></i> Edit\
                                            </a>\
                                            \<a class="dropdown-item" href=/admin/product/' + id + '/values>\
                                                <i class="bx bxs-grid"></i> View Product Attribute Values\
                                            </a>\
                                        @endif\
                                         @if(auth()->user()->checkPermissionAccess('delete-account'))\
                                            <a class="dropdown-item action_delete"\
                                                data-url="/admin/products/' + id + '/delete"\>\
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
