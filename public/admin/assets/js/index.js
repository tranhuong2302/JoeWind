function checkBoxAll() {
    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
}

function actionDelete(event) {
    event.preventDefault();
    let urlRequest = $(this).data('url');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'DELETE',
                url: urlRequest,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.status === 'SUCCESS') {
                        $('#table-dataTable').DataTable().ajax.reload(null, false);
                        // that.remove();
                        toastr.success('Delete success.', 'Success',
                            {
                                closeButton: true,
                                progressBar: true,
                                newestOnTop: true,
                                timeOut: "3000",
                            }
                        )

                    }
                }
            });
        }
    })
}

function actionDeleteRecursive(event) {
    event.preventDefault();
    let urlRequest = $(this).data('url');
    let that = $(this).parents("tr");
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'DELETE',
                url: urlRequest,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.status === 'SUCCESS') {
                        $('#table-dataTableRecursive').DataTable().row(that).remove().draw(false);
                        toastr.success('Delete success.', 'Success',
                            {
                                closeButton: true,
                                progressBar: true,
                                newestOnTop: true,
                                timeOut: "3000",
                            }
                        )

                    }
                }
            });
        }
    })
    console.log(that);
    console.log(urlRequest);
}

function actionDeleteMultiple(event) {
    event.preventDefault();
    var allIds = [];
    var urlRequests = $(this).data("url");
    $("input:checkbox[name=ids]:checked").each(function () {
        allIds.push($(this).val());
    });
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlRequests,
                type: "DELETE",
                data: {
                    ids: allIds,
                },
                success: function (response) {
                    if (response.status === "SUCCESS") {
                        $('#table-dataTable').DataTable().ajax.reload(null, false);
                        $(".checkBoxAll").prop('checked', false);
                        toastr.success('Delete selected success.', 'Success',
                            {
                                closeButton: true,
                                progressBar: true,
                                newestOnTop: true,
                                timeOut: "3000",
                            }
                        )
                    }
                }
            });
        }
    })
}

function actionDeleteMultipleRecursive(event) {
    event.preventDefault();
    var allIds = [];
    var urlRequests = $(this).data("url");
    $("input:checkbox[name=ids]:checked").each(function () {
        allIds.push($(this).val());
    });
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlRequests,
                type: "DELETE",
                data: {
                    ids: allIds,
                },
                success: function (response) {
                    if (response.status === "SUCCESS") {
                        $.each(allIds, function (key, value) {
                            $('#table-dataTableRecursive').DataTable().row("#sid" + value).remove().draw(false);
                        })
                        $(".checkBoxAll").prop('checked', false);
                        toastr.success('Delete selected success.', 'Success',
                            {
                                closeButton: true,
                                progressBar: true,
                                newestOnTop: true,
                                timeOut: "3000",
                            }
                        )
                    }
                }
            });
        }
    })
}

$(function () {
    $(".checkBoxAll").click(checkBoxAll);
    $('#table-dataTable').on('click', 'form.action_delete', actionDelete);
    $('#table-dataTableRecursive').on('click','form.action_deleteRecursive', actionDeleteRecursive);
    $("#deleteAllSelectedRecord").click(actionDeleteMultiple);
    $("#deleteAllSelectedRecordRecursive").click(actionDeleteMultipleRecursive);
});
