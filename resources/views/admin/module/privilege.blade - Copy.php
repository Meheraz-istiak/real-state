@extends('admin.main')
@section('title','privilege')
@section('css')
    <link href="{{ URL::asset('assets/plugins/morris/morris.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/rating/rating.css')}}" rel="stylesheet">
    <style>
        .roleList {
            font-size: 15px;
        }
    </style>
@endsection
@section('page-header')
    <!-- PAGE-HEADER -->
    <div>
        <h1 class="page-title">Dashboard</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Privilege</li>
        </ol>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="card">
                <div class="list-group list-group-transparent mb-0 mail-inbox">
                    <div class="mt-4 mb-4 ml-4 mr-4 text-right">
                        <button class="btn btn-secondary btn-md btn-block" data-target="#roleForm" data-toggle="modal"
                                data-original-title="New Role" onclick="ResetForm();">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <span class="hidden-xs">New Role</span>
                        </button>
                    </div>
                    <div id="allRoleId">
                        <ul style="width: 100%;margin-left: 25px;" id="userRole">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12">
            <!-- Modal -->
            <div class="modal fade" id="roleForm" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Role Form</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    onclick="ResetForm();">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-role" name="form-role" autocomplete="off">
                                @csrf
                                <div class="container-fluid">
                                    <input type="hidden" name="hiddenRoleId" id="hiddenRoleId" value="0">
                                    <div class="row mt-3">
                                        <label class="col-md-3 control-label">Name :</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name"
                                                   placeholder="give role name">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <label class="col-md-3 control-label">Description :</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="description" id="description" cols="30"
                                                      rows="5" placeholder="Write something..."></textarea>
                                        </div>
                                    </div>

                                    <hr/>
                                    <div class="model-footer text-right">
                                        <label class="wc-error pull-left" id="form_error"></label>
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3"
                                               id="btnRoleFormSubmit">
                                        {{--                                        <button type="button" class="btn btn-primary mr-3" id="btnUserFormSubmit" >Submit</button>--}}
                                        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal"
                                                aria-label="Close" onclick="ResetForm();">Close
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

            <div class="card">
                <div class="card-header mb-3">
                    <div class="col-lg-6">
                        <h4 class="card-title">Privilege list of<span
                                class="badge badge-primary badge-sm badge-pill ml-2 roleName"></span></h4>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table id="privilege-table"
                           class="table table-bordered table-hover dataTable table-striped width-full">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Url</th>
                            <th class="text-center" style="width:80px;">Enable</th>
                        </tr>
                        </thead>
                        <tbody id="all-privilege">

                        </tbody>
                    </table>

                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- ROW-1 CLOSED -->

@endsection
@section('js')

    <script type="text/javascript">

        function ResetForm() {
            $('#form-lookup')[0].reset();
        }

        $(document).ready(function () {
            //get all role
            $.ajax({
                url: "{{ route('all.role') }}",
                type: "GET",
                success: function (response) {
                    var data = JSON.stringify(response.data)
                    var res = JSON.parse(data)

                    var html = '<li class="roleList"><a data-toggle="tab" href="javascript:void(0)" onclick="loadPrivTable(1)">' +
                        '<span class="icon mr-3 font-weight-bold">Super Admin</span></a></li>';
                    var active = '';
                    if (res.length > 0) {
                        for (let i = 1; i < res.length; i++) {
                            html += '<li class="roleList"><a href="javascript:void(0)" onclick="loadPrivTable(' + res[i].id + ')">' +
                                '<span class="icon mr-3 font-weight-bold">' + res[i].name + '</span></a></li>';
                        }
                    }
                    // console.log(html)
                    $("#userRole").html(html);
                }

            });

            loadPrivTable(1);

        });

        function loadPrivTable(id) {
            // alert(id)
            $('#privilege-table').DataTable({
                "ajax": {
                    "url": "{{route('show.privilege')}}",
                    "type": "GET",
                    "data": {
                        "roleid": id
                    }
                },
                columns: [
                    {"data": "id", "class": "text-center"},
                    {"data": "name"},
                    {"data": "url"},
                    {
                        "data": null, "sortable": false, "class": "text-center",
                        "render": function (data, type, full) {
                            if (full['access'] == 0)
                                return '<button class="btn btn-sm btn-icon btn-flat btn-default" data-toggle="Enable" data-original-title="Enable" onclick="ChangeEnable(' + full['roleid'] + ', ' + full['id'] + ', 1)"><i class="fa fa-check" style="color:lightgray;font-size: 15px;" aria-hidden="true"></i></button>';
                            else
                                return '<button class="btn btn-sm btn-icon btn-flat btn-default" data-toggle="Enable" data-original-title="Enable" onclick="ChangeEnable(' + full['roleid'] + ', ' + full['id'] + ', 0)"><i class="fa fa-check" style="color:limegreen;font-size: 15px;" aria-hidden="true"></i></button>';
                        }
                    }],
                "paging": true,
                "stateSave": true,
                "bDestroy": true
            });

        }

        function ChangeEnable(roleid, moduleid, action) {
            $.ajax({
                url: "{{ route('privilege.update') }}",
                type: "GET",
                data: {
                    "roleid": roleid,
                    "moduleid": moduleid,
                    "action": action,
                },
                success: function (response) {

                    if (response.success == true) {
                        Toast.fire({
                            type: 'success',
                            title: response.msg,
                        });
                        loadPrivTable(roleid)
                    }
                },
                error: function (error) {
                    Toast.fire({
                        type: 'error',
                        title: 'Something Error Found, Please try again.',
                    });
                }

            });
        }

    </script>

    <script src="{{ URL::asset('assets/js/index3.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/Chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart/utils.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/morris/raphael-min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/morris/morris.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/rating/jquery.barrating.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/rating/ratings.js') }}"></script>


@endsection
