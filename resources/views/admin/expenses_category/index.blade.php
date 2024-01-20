@extends('admin.main')
@section('title','Expenses category')
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
        <li class="breadcrumb-item active" aria-current="page">Expenses category</li>
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
                    <h3 class="card-title">Expenses category</h3>
                </div>
                <div class="col-lg-6 text-right">
                    <button class="btn btn-info" data-target="#ExpensesCategoryForm" data-toggle="modal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <span class="hidden-xs">Add Expenses category</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="expenses-category-table" class="table table-hover dataTable table-striped width-full">
                    <thead>
                        <tr>
                            <th class="text-center">NAME</th>
                            <th class="text-center">CATEGORY TYPE</th>
                            <th class="text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="all-lookups">

                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- COL END -->

    <!-- Modal -->
    <div class="modal fade" id="ExpensesCategoryForm" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Expenses category From</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetExpenseCategoryForm();">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-expenses-category" name="form-expenses-category" autocomplete="off">
                        @csrf
                        <div class="container-fluid">
                            <input type="hidden" name="hiddenexpensescategoryId" id="hiddenexpensescategoryId" value="0">
                            <div class="row mt-3">
                                <label class="col-md-3 control-label">Name :</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Write expenses name">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-md-3 control-label">Type:</label>
                                <div class="col-md-9 wrap-input100 validate-input">
                                    <select class="form-control" name="category_type" id="category_type">
                                        <option label="Choose one"></option>
                                        <option value="1">Global</option>
                                        <option value="2">Project Base</option>

                                    </select>
                                </div>
                            </div>
                            <hr />
                            <div class="model-footer text-right">
                                <label class="wc-error pull-left" id="form_error"></label>
                                <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="">
                                <button type="button" class="btn btn-default btn-outline" data-dismiss="modal" aria-label="Close" onclick="ResetExpenseCategoryForm();">Close</button>
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
    function ResetExpenseCategoryForm() {
        $('#form-expenses-category')[0].reset();
        $('#hiddenexpensescategoryId').val('')
    }

    $(document).ready(function() {
        $('#expenses-category-table').DataTable({
            ajax: "{{ route('all.ExpensesCategory') }}",
            columns: [
                {
                     data: 'name',
                    "class": "text-center"
                },
                {
                    data: 'category_type',
                    "class": "text-center",
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
                    data: null,
                    sortable: false,
                    className: "text-left padding-5",
                    "class": "text-center",
                    render: function(data, type, full) {
                        return "<button class='btn btn-warning btn-sm btn-edit' data-target='#ExpensesCategoryForm' data-toggle='modal' data-toggle='Edit Lookup' data-original-title='Edit Lookup' onclick='getEditexpenses_category(" + full.id + ")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteexpenses_category(" + full.id + ")'>Delete</button>";
                    }
                }
            ]
        });
    });

    // PARENT NAV ROUTE
    // $.ajax({
    //     url: "{{ route('lookup.parent') }}",
    //     type: "GET",
    //     success: function(response) {
    //         // console.log(response)
    //         var html = '<option value=""> choose a parent</option>';
    //         if (response.length > 0) {
    //             for (let i = 0; i < response.length; i++) {
    //                 html += '<option value="' + response[i]['id'] + '">' + response[i]['name'] + '</option>';
    //             }
    //         }

    //         $("#lookupparent").html(html);
    //     }

    // });


    //    navigation submit

    $('#form-expenses-category').on("submit", function(event) {
        event.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            url: "{{route('add.ExpensesCategory')}}",
            data: form,
            type: "POST",
            success: function(response) {

                if (response.success == true) {
                    $("#form-expenses-category")[0].reset();
                    $('#ExpensesCategoryForm').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: response.msg,
                    });
                    ResetExpenseCategoryForm();
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
    function getEditexpenses_category(id) {
        $.ajax({
            url: "{{ url('expenses-category-edit') }}/" + id,
            type: "GET",
            success: function(response) {

                $("#hiddenexpensescategoryId").val(response.id);
                $("#name").val(response.name);
                $("#category_type").val(response.category_type);
                // $("#lookupparent").val(response.parent).change();

            }

        });
    }

    //    DELETE OPTION
    function getDeleteexpenses_category(id) {
        var result = confirm("Are you sure to delete?");
        if (result) {
            $.ajax({
                url: "{{ url('expenses-category-delete') }}/" + id,
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