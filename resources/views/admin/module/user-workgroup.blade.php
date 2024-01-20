@extends('admin.main')
@section('title','user workgroup')
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
            <li class="breadcrumb-item active" aria-current="page">User Workgroup</li>
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
                        <h3 class="card-title">All User Workgroup</h3>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button class="btn btn-info"  data-target="#userWorkgroupForm" data-toggle="modal" data-original-title="Add New user workgroup" onclick="ResetForm();">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span class="hidden-xs">Add New User workgroup</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{--Search: <input type="text" id="myInput" onkeyup="searchData();" placeholder="Search for names.." title="Type in a name">--}}
                    <table id="user-workgroup-table" class="table table-hover dataTable table-striped width-full">
                        <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>User</th>
                            <th>Workgroup</th>
                            <th>Is Supervisor</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody id="all-user-workgroups">

                        </tbody>
                    </table>
                    {{--                    <div class="mt-3" style="margin-right: 40px">--}}
                    {{--                        <button id="prevButton" style="border: 1px solid black">Previous</button>--}}
                    {{--                        <button id="nextButton" style="border: 1px solid black">Next</button>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div><!-- COL END -->

        <!-- Modal -->
        <div class="modal fade" id="userWorkgroupForm" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">User workgroup Form</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetForm();">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form  id="form-user-workgroup" name="form-user-workgroup" autocomplete="off" >
                            @csrf
                            <div class="container-fluid">
                                <input type="hidden" name="hiddenUsergroupId" id="hiddenUsergroupId" value="0">

                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">User:</label>
                                    <div class="col-md-9 wrap-input100 validate-input">
                                        <select class="form-control"  name="userid" id="userid" placeholder="select user">
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Workgroup:</label>
                                    <div class="col-md-9 wrap-input100 validate-input">
                                        <select class="form-control"  name="workgroupid" id="workgroupid" placeholder="select user">
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">IsSupervisor: </label>
                                    <div class="col-md-9">
                                        <div class="checkbox-custom checkbox-primary">
                                            <input type="checkbox" id="issupervisor" name="issupervisor" checked />
                                            <label for="issupervisor"></label>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="model-footer text-right">
                                    <label class="wc-error pull-left" id="form_error"></label>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnUserWorkgroupForm">
                                    {{-- <button type="button" class="btn btn-primary mr-3" id="btnUserFormSubmit" >Submit</button>--}}
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
            $('#form-user-workgroup')[0].reset();
        }

        $(document).ready(function () {
            $('#user-workgroup-table').DataTable({
                ajax:"{{ route('all.user.workgroup') }}",
                columns: [
                    { data: 'id' },
                    { data: 'username' },
                    { data: 'workgroupname' },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            if (full["issupervisor"] == 1) {
                                return '<p>'+'Yes'+'</p>';
                            } else {
                                return '<p>'+'No'+'</p>';
                            }
                        }
                    },
                    {
                        "data": null, "sortable": false, "class": "text-left padding-5",
                        "render": function (data, type, full) {
                            return "<button class='btn btn-warning btn-sm btn-edit' data-target='#userWorkgroupForm' data-toggle='modal' data-toggle='Edit User Workgroup' data-original-title='Edit User Workgroup' onclick='getEditUserWorkgroup("+full['id']+")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteUserWorkgroup("+full['id']+")'>Delete</button>";
                        }
                    },
                ],
            });

        });


        // USER ROUTE
        $.ajax({
            url: "{{ route('workgroup.user') }}",
            type: "GET",
            success: function (response) {
                // console.log(response)
                var html = '<option value=""> choose a user</option>';
                if (response.length >0){
                    for (let i=0;i<response.length; i++){
                        html +='<option value="'+response[i]['id']+'">'+response[i]['first_name']+'</option>';
                    }
                }

                $("#userid").html(html);
            }

        });

        // WORK GROUP ROUTE
        $.ajax({
            url: "{{ route('workgroup.all.id') }}",
            type: "GET",
            success: function (response) {
                // console.log(response)
                var html = '<option value=""> choose a user</option>';
                if (response.length >0){
                    for (let i=0;i<response.length; i++){
                        html +='<option value="'+response[i]['id']+'">'+response[i]['name']+'</option>';
                    }
                }

                $("#workgroupid").html(html);
            }

        });


        //    user workgroup submit

        $('#form-user-workgroup').on("submit",function(event){
            event.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url:"{{route('add.user.workgroup')}}",
                data:form,
                type:"POST",
                success:function(response){

                    if (response.success == true){
                        $("#form-user-workgroup")[0].reset();
                        $('#userWorkgroupForm').modal('hide');
                        Toast.fire({
                            type:'success',
                            title:response.msg,
                        });
                        $('#user-workgroup-table').DataTable().ajax.reload();
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
        function getEditUserWorkgroup(id) {
            $.ajax({
                url: "{{ url('user-workgroup-edit') }}/"+id,
                type: "GET",
                success: function (response) {

                    $("#hiddenUsergroupId").val(response.id);
                    $("#userid").val(response.userid).change();
                    $("#workgroupid").val(response.workgroupid).change();

                    if(response.issupervisor !=1){
                        $('#issupervisor').removeAttr('checked');
                    } else {
                        $('#issupervisor').attr('checked','checked');
                    }
                }

            });
        }

        //    DELETE OPTION
        function getDeleteUserWorkgroup(id) {
            var result = confirm("Are you sure to delete?");
            if(result){
                $.ajax({
                    url: "{{ url('user-workgroup-delete') }}/"+id,
                    type: "DELETE",
                    success: function (response) {

                        if(response.success == true){
                            Toast.fire({
                                type:'success',
                                title:response.msg,
                            });
                            $('#user-workgroup-table').DataTable().ajax.reload();
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
