@extends('admin.main')
@section('title','workgroup')
@section('css')
{{--    <link href="{{ URL::asset('assets/plugins/morris/morris.css')}}" rel="stylesheet">--}}
{{--    <link href="{{ URL::asset('assets/plugins/rating/rating.css')}}" rel="stylesheet">--}}
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">Dashboard</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Workgroup</li>
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
                        <h3 class="card-title">All Workgroup</h3>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-info"  data-target="#workgroupForm" data-toggle="modal" data-original-title="Add New workgroup" onclick="ResetForm();">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span class="hidden-xs">Add New Workgroup</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                  <table id="workgroup-table" class="table table-hover dataTable table-striped width-full">
                        <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>NAME</th>
                            <th>DESCRIPTION</th>
                            <th>PARENT</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody id="all-workgroups">

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- COL END -->

        <!-- Modal -->
        <div class="modal fade" id="workgroupForm" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Workgroup Form</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetForm();">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form  id="form-workgroup" name="form-workgroup" autocomplete="off" >
                            @csrf
                            <div class="container-fluid">
                                <input type="hidden" name="hiddenWorkgroupId" id="hiddenWorkgroupId" value="0">
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Name :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="give workgroup name">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Description :</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Write something..."></textarea>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Parent:</label>
                                    <div class="col-md-9 wrap-input100 validate-input">
                                        <select class="form-control"  name="workgroupparent" id="workgroupparent" placeholder="select parent">
                                        </select>
                                    </div>
                                </div>
                                <hr />
                                <div class="model-footer text-right">
                                    <label class="wc-error pull-left" id="form_error"></label>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnWorkgroupForm">
                                    {{--                                        <button type="button" class="btn btn-primary mr-3" id="btnUserFormSubmit" >Submit</button>--}}
                                    <button type="button" class="btn btn-default btn-outline" data-dismiss="modal" aria-label="Close" onclick="ResetForm();">Close</button>
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

        function ResetForm() {
            $('#form-workgroup')[0].reset();
        }

        $(document).ready(function () {

            $('#workgroup-table').DataTable({
                ajax:"{{ route('all.workgroup') }}",
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'description' },
                    { data: 'parentname' },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return "<button class='btn btn-warning btn-sm btn-edit' data-target='#workgroupForm' data-toggle='modal' data-toggle='Edit Workgroup' data-original-title='Edit Workgroup' onclick='getEditWorkgroup("+full['id']+")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteWorkgroup("+full['id']+")'>Delete</button>";
                        }
                    },
                ],
            });

        });

        // PARENT NAV ROUTE
        $.ajax({
            url: "{{ route('workgroup.parent') }}",
            type: "GET",
            success: function (response) {
                // console.log(response)
                var html = '<option value=""> choose a parent</option>';
                if (response.length >0){
                    for (let i=0;i<response.length; i++){
                        html +='<option value="'+response[i]['id']+'">'+response[i]['name']+'</option>';
                    }
                }

                $("#workgroupparent").html(html);
            }

        });


        //    navigation submit

        $('#form-workgroup').on("submit",function(event){
            event.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url:"{{route('add.workgroup')}}",
                data:form,
                type:"POST",
                success:function(response){

                    if (response.success == true){
                        ResetForm();
                        $('#workgroupForm').modal('hide');
                        Toast.fire({
                            type:'success',
                            title:response.msg,
                        });
                        $('#workgroup-table').DataTable().ajax.reload();
                    }
                },
                error:function(error){
                    Toast.fire({
                        type:'error',
                        title:'Something Error Found, Please try again.',
                    });
                }
            });
        });

        // edit option
        function getEditWorkgroup(id) {
            $.ajax({
                url: "{{ url('workgroup-edit') }}/"+id,
                type: "GET",
                success: function (response) {

                    $("#hiddenWorkgroupId").val(response.id);
                    $("#name").val(response.name);
                    $("#description").val(response.description);
                    $("#workgroupparent").val(response.parent).change();

                }

            });
        }

        //    DELETE OPTION
        function getDeleteWorkgroup(id) {
            var result = confirm("Are you sure to delete?");
            if(result){
                $.ajax({
                    url: "{{ url('workgroup-delete') }}/"+id,
                    type: "DELETE",
                    success: function (response) {

                        if(response.success == true){
                            Toast.fire({
                                type:'success',
                                title:response.msg,
                            });
                            $('#workgroup-table').DataTable().ajax.reload();
                        }

                    },
                    error:function(error){
                        Toast.fire({
                            type:'error',
                            title:'Something Error Found, Please try again.',
                        });
                    }

                });
            }

        }

    </script>

@endsection
