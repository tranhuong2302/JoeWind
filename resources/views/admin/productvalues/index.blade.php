@extends('admin.layouts.admin')
@section('active-product-manage', 'active open')
@section('active-products', 'active')
@section('title')
    <title>Product Manage - List Product Attribute Value</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap5.min.css" rel="stylesheet"/>
@endsection
@section('content')
    @include('admin.partials.content-header', ['pages' => 'Product Manage', 'name' => 'Products'])
    @include('admin.productvalues.modal')
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        @if(auth()->user()->checkPermissionAccess('list-products') == true)
            <li class="nav-item">
                <a class="btn btn-outline-primary" href="{{route('products.index')}}"><i
                        class="bx bxl-product-hunt me-1"></i> List Product</a>
            </li>
        @endif
    </ul>
    <div class="card">
        <h5 class="card-header">List Product Attribute Values</h5>
        <div class="col-sm-12">
            @include('admin.partials.alert')
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="table-dataTable">
                <thead>
                <tr>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Plus Price</th>
                    <th scope="col">Quantity</th>
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
    <script>
        const productId = window.location.pathname.split("/")[3];
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
                    url: '/api/admin/product/' + productId + '/values',
                },
                columns: [
                    {data: "id"},
                    {data: "attribute_value_name"},
                    {
                        data: "plus_price",
                        'render': function (price) {
                            return new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(price);
                        }
                    },
                    {data: "quantity"},
                    {
                        data: 'id',
                        'render': function (id) {
                            return (
                                '@if(auth()->user()->checkPermissionAccess('edit-product'))\
                                    <button class="btn btn-outline-primary me-3 editProductAttributeValue"  id="' + id + '"\
                                        data-bs-toggle="modal"  data-bs-target="#modalCenter">\
                                            <i class="bx bx-edit-alt me-1"></i> Edit\
                                    </button>\
                                @endif'
                            )
                        },
                    },
                ]
            });
        });

        $('table').on('click', '.editProductAttributeValue', function () {
            const productAttributeValue_id = $(this).attr('id');
            $.get('/api/admin/product/' + productId + '/values/' + productAttributeValue_id, function (response) {
                $('#modalCenterTitle').html("Edit Product Attribute Value");
                $('.saveBtn').html("Save Changes");
                $('#productAttributeValueId').val(response.data.id);
                $('.name').val(response.data.attribute_value_name);
                $('.plus_price').val(response.data.plus_price);
                $('.quantity').val(response.data.quantity);
            })
        });

        $('.saveBtn').click(function (e) {
            const plus_price = $('.plus_price').val();
            const quantity = $('.quantity').val();
            const productAttributeValue_id = $('#productAttributeValueId').val();
            const url = "/api/admin/product/" + productId + "/values/" + productAttributeValue_id;
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                url: url,
                type: "PUT",
                data: {
                    plus_price: plus_price,
                    quantity: quantity,
                },
                success: function (response) {
                    $('#modalCenter').modal('hide');
                    $('#table-dataTable').DataTable().ajax.reload(null, false);
                    toastr.success('Edit attribute value success.', 'Success',
                        {
                            closeButton: true,
                            progressBar: true,
                            newestOnTop: true,
                            timeOut: "3000",
                        }
                    )
                },
                error: function () {
                    toastr.error('Edit attribute value error', 'Error',
                        {
                            closeButton: true,
                            progressBar: true,
                            newestOnTop: true,
                            timeOut: "3000",
                        }
                    )
                }
            });
        });
    </script>
@endsection
