@extends('admin.main')
@section('title','Expenses')
@section('css')
{{-- <link href="{{ URL::asset('assets/plugins/morris/morris.css')}}" rel="stylesheet">--}}
{{-- <link href="{{ URL::asset('assets/plugins/rating/rating.css')}}" rel="stylesheet">--}}
@endsection
@section('page-header')
<!-- PAGE-HEADER -->
<div>
    <h1 class="page-title">Dashboard</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Expenses</li>
    </ol>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="col-lg-6">
                    <h3 class="card-title">Expenses</h3>
                </div>
                <div class="col-lg-6 text-right">
                    <button class="btn btn-info" data-target="#ExpensesForm" data-toggle="modal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <span class="hidden-xs">Add Expenses</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="expenses-category-table" class="table table-hover dataTable table-striped width-full">
                    <thead>
                        <tr>
                            <th>EXPENSES</th>
                            <th>TYPE </th>
                            <th>AMOUNT</th>
                            <th>PROJECT</th>
                            <th>ITEM</th>
                            <th>NOTE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="all-lookups">

                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- COL END -->

    <!-- Modal -->
    <div class="modal fade" id="ExpensesForm" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Expenses From</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetexpenseForm();">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-expenses" name="form-expenses" autocomplete="off">
                        @csrf
                        <div class="container-fluid">


                            <input type="hidden" name="hiddenexpensesId" id="hiddenexpensesId" value="0">
                            <input type="hidden" id="item_id_hidden" value="0">

                            <div class="row mt-3 mb-3">
                                <label for="category_id" class="col-md-3 control-label">Expense:</label>
                                <div class="col-md-9 wrap-input100 validate-input">
                                    <select class="form-control" name="category_id" id="category_id" placeholder="select parent">
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3 mb-3">
                                <label for="project_id" class="col-md-3 control-label">Project:</label>
                                <div class="col-md-9 wrap-input100 validate-input">
                                    <select class="form-control" id="project_id" name="project_id">
                                    </select>
                                </div>
                                <label for="item_id" class="col-md-3 control-label mt-4">Item:</label>
                                <div class="col-md-9 mt-4 wrap-input100 validate-input">
                                    <select class="form-control" id="item_id" name="item_id">
                                    </select>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <label class="col-md-3 control-label">Amount :</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="amount" id="amount" placeholder="0.00">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-md-3 control-label">Note :</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="note" id="note" cols="30" rows="5" placeholder="Write something..."></textarea>
                                </div>
                            </div>

                            <hr />
                            <div class="model-footer text-right">
                                <label class="wc-error pull-left" id="form_error"></label>
                                <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnLookupForm">

                                <button type="button" class="btn btn-default btn-outline" data-dismiss="modal" aria-label="Close" onclick="ResetexpenseForm();">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
</div>

@endsection
@section('js')

<script type="text/javascript">
    function ResetexpenseForm() {
        $('#form-expenses')[0].reset();
        $('#item_id').val('').change();
        $('#hiddenexpensesId').val(0).change();
    }

    $(document).ready(function() {

        $('#expenses-category-table').DataTable({
            ajax: "{{ route('all.Expenses') }}",
            columns: [

                {
                    data: 'expenses_category_name'
                },

                {
                    data: 'category_type',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return 'Global';
                        } else if (data == 2) {
                            return 'Project';
                        } else {
                            return 'Unknown';
                        }
                    }
                },

                {
                    data: 'amount',
                    render: function(data, type, row) {
                        var formattedAmount = parseFloat(data).toLocaleString();
                        return '৳ ' + formattedAmount; // Add currency sign before the formatted amount
                    }
                },

                {
                    data: 'project_name'
                },
                {
                    data: 'item_name'
                },
                {
                    data: 'note'
                },

                {
                    data: null,
                    sortable: false,
                    className: "text-left padding-5",
                    render: function(data, type, full) {
                        return "<button class='btn btn-warning btn-sm btn-edit' data-target='#ExpensesForm' data-toggle='modal' data-toggle='Edit Lookup' data-original-title='Edit Lookup' onclick='getEditexpenses(" + full.id + ")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteexpenses(" + full.id + ")'>Delete</button>";
                    }
                },

            ]
        });
    });

    $('#category_id').on('change', function() {
        // var expenseType = $(this).val();
        var expenseType = $(this).find(':selected').data('type');
        //  alert(expenseType);
        if (expenseType == 1) {
            // If Global is selected, disable projectId and itemId inputs
            $('#project_id').prop('disabled', true);
            $('#item_id').prop('disabled', true);
            $('#project_id').val('').change();



        } else if (expenseType == 2) {
            // If Project is selected, enable projectId and itemId inputs
            $('#project_id').prop('disabled', false);
            $('#item_id').prop('disabled', false);
            $('#project_id').prop('required', true);
            $('#item_id').prop('required', true);
        }


    });
    // PARENT NAV ROUTE
    $.ajax({
        url: "{{ route('all.Expenses.category') }}",
        type: "GET",
        success: function(response) {
            console.log(response)
            var html = '<option value="">Choose Expense Name</option>';
            if (response.length > 0) {
                for (let i = 0; i < response.length; i++) {
                    html += '<option value="' + response[i]['id'] + '" data-type="' + response[i]['category_type'] + '">' + response[i]['name'] + '</option>';
                }
            }

            $("#category_id").html(html);
        }

    });

    // Populate project dropdown
    $.ajax({
        url: "{{ route('getProject') }}",
        type: "GET",
        success: function(response) {

            var html = '<option value="">Choose Project Name</option>';
            if (response.length > 0) {
                for (let i = 0; i < response.length; i++) {
                    html += '<option value="' + response[i]['id'] + '">' + response[i]['name'] + '</option>';
                }
            }
            $("#project_id").html(html);
        }
    });

    // Handle change event of project dropdown to populate item dropdown
    $(document).on('change', '#project_id', function() {
        var projectId = $(this).val();

        if (projectId) {
            $.ajax({
                url: "{{ url('get-item') }}" + '/' + projectId,
                type: "GET",
                success: function(response) {

                    var html = '<option value="">Choose Item</option>';
                    if (response) {
                        for (let i = 0; i < response.length; i++) {
                            html += '<option value="' + response[i]['id'] + '">' + response[i]['name'] + '</option>';
                        }
                    }
                    $("#item_id").html(html);
                    if ($('#item_id_hidden').val() !== 0) {
                        $("#item_id").val($('#item_id_hidden').val());
                    }
                }
            });

        } else {
            $("#item_id").html('<option value="">Choose Project First</option>');
        }
    });

    //    navigation submit

    $('#form-expenses').on("submit", function(event) {
        event.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            url: "{{route('add.Expenses')}}",
            data: form,
            type: "POST",
            success: function(response) {

                if (response.success == true) {
                    $("#form-expenses")[0].reset();
                    $('#ExpensesForm').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: response.msg,

                    });
                    ResetexpenseForm()
                    $('#expenses-category-table').DataTable().ajax.reload();

                }
            },
            error: function(error) {
                Toast.fire({
                    type: 'error',
                    title: 'Something Error Found, Please try again.',
                });
            }
        });
    });

    // edit option
    function getEditexpenses(id) {
        $.ajax({
            url: "{{ url('expenses-edit') }}/" + id,
            type: "GET",
            success: function(response) {
                // console.log(response);
                $("#hiddenexpensesId").val(response.id);
                $("#category_id").val(response.category_id).change();
                $("#item_id_hidden").val(response.item_id);
                $("#project_id").val(response.project_id).trigger('change'); // Trigger change event manually
                //$("#item_id").val(response.item_id);
                $("#amount").val(response.amount);
                $("#note").val(response.note);

            }
        });
    }


    //    DELETE OPTION
    function getDeleteexpenses(id) {
        var result = confirm("Are you sure to delete?");
        if (result) {
            $.ajax({
                url: "{{ url('expenses-delete') }}/" + id,
                type: "DELETE",
                success: function(response) {

                    if (response.success == true) {
                        Toast.fire({
                            type: 'success',
                            title: response.msg,
                        });
                        $('#expenses-category-table').DataTable().ajax.reload();
                    }

                },
                error: function(error) {
                    Toast.fire({
                        type: 'error',
                        title: 'Something Error Found, Please try again.',
                    });
                }

            });
        }

    }
</script>

@endsection