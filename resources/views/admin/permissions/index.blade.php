@extends('admin.layouts.admin')
@section('active-account-manage', 'active open')
@section('active-permissions', 'active')
@section('title')
    <title>Account Manage - List Permissions</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap5.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <!-- Striped Rows -->
    @include('admin.partials.content-header', ['pages' => 'Account Manage', 'name' => 'Permissions'])
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-list-ul me-1"></i> List
                Permissions
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('permissions.create')}}">
                <i style="font-size: 24px;" class="bx bx-plus-circle me-1"></i>Create Permission
            </a>
        </li>
        <li class="nav-item">
            <button id="deleteAllSelectedRecordRecursive" class="btn btn-outline-danger"
                    data-url="{{ route('permissions.deleteSelected')}}">
                <i class="bx bx-trash me-1"></i>Delete Permission
            </button>
        </li>
    </ul>
    <div class="card">
        <h5 class="card-header">List Permissions</h5>
        <div class="col-sm-12">
            @include('admin.partials.alert')
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="table table-hover" id="table-dataTableRecursive">
                <thead>
                <tr>
                    <th scope="col"><input type="checkbox" name="ids" class="form-check-input checkBoxAll">
                    </th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Display Name</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                {!! $html !!}
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
            $('#table-dataTableRecursive').DataTable({
                lengthChange: false,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
                ],
            });
        });
    </script>

@endsection
