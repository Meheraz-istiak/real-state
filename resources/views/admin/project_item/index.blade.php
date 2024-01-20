@extends('admin.main')
@section('title','project-item')
@section('css')
<link href="{{ URL::asset('assets/plugins/multipleselect/multiple-select.css')}}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<style>
    .roleList {
        font-size: 15px;
    }

    .hiddenTitle h1 {
        font-size: 25px;
        color: #DCDBDB;
    }

    .hiddenImage {
        margin-left: 240px;
        height: 250px;
        opacity: 0.2;
    }

    #projectList .selectedItem {
        display: block;
        height: 100%;
        width: 100%;
        line-height: 35px;
        color: black;
        box-sizing: border-box;
        border-top: 1px solid rgba(255, 255, 255, .1);
        border-bottom: 1px solid rgba(255, 255, 255, .1);
        border-radius: 0;
    }

    #projectList .active,
    #projectList .active a {
        background-color: #E7EEEC;
        color: black;
    }
</style>
@endsection
@section('page-header')
<!-- PAGE-HEADER -->
<div>
    <h1 class="page-title">Dashboard</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">project List</li>
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
                <div class="mt-4 mb-4 mr-4 text-center">
                    <h3>Project List</h3>

                </div>
                <ul style="width: 100%;" id="projectList">

                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-12 col-sm-12">
        <!-- Modal -->
        <div class="modal fade" id="ProjectitemForm" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Project Item Form</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetFormPriv();">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="projectItemFrom" name="projectItemFrom" autocomplete="off">
                            @csrf
                            <div class="container-fluid">
                                <input type="hidden" name="project_id" id="hiddenProjectId" value="0">
                                <input type="hidden" name="projectItem_id" id="projectItem_id" value="0">

                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Name :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Write your project item name">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Item position :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="item_position" id="item_position" placeholder="Write your item position">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">Item side :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="item_side" id="item_side" placeholder="Write your item side">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label">price :</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="price" id="price" placeholder="Write your price">
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <label class="col-md-3 control-label">Item type:</label>
                                    <div class="col-md-9 wrap-input100 validate-input">
                                        <select class="form-control" name="item_type" id="item_type" >
                                        </select>
                                    </div>
                                </div>

                                <hr />
                                <div class="model-footer text-right">
                                    <label class="wc-error pull-left" id="form_error"></label>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnRoleFormSubmit">
                                    <button type="button" class="btn btn-default btn-outline" data-dismiss="modal" aria-label="Close" onclick="ResetFormPriv();">Close
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
                <div class="col-lg-12 hiddenTitle text-center">
                    <h1 class="card-title">Please select a project</h1>
                </div>
                <div class="col-lg-6 showTitle">
                    <h4 class="card-title">Item List of <span class="ml-2 target-element"></span></h4>
                </div>
                <div class="col-lg-6 text-right showTitle">
                    <button class="btn btn-info" data-target="#ProjectitemForm" data-toggle="modal" data-original-title="Add New role"">
                        <i class=" fa fa-plus" aria-hidden="true"></i>
                        <span class="hidden-xs">Add New</span>
                    </button>
                </div>
            </div>

            <div class="card-body pt-0">

                <img src="{{asset('assets/images/logos/nodata.jpg')}}" class="hiddenImage" alt="">

                <table id="privilege-table" class="table table-bordered table-hover dataTable table-striped width-full table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Item position</th>
                            <th>Item side</th>
                            <th>Price</th>
                            <th class="text-center">Action</th>
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
<script src="{{ URL::asset('assets/plugins/multipleselect/multiple-select.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/multipleselect/multi-select.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">
    function ResetFormPriv() {
        $('#projectItemFrom')[0].reset();
        $('#projectItem_id').val('')
    }

    $("#privilege-table").hide();
    $(".hiddenTitle").show();
    $(".hiddenImage").show();
    $(".showTitle").hide();

    $(document).ready(function() {

        //projectItem submit
        $('#projectItemFrom').on("submit", function(event) {
            event.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url: "{{route('store.project-item')}}",
                data: form,
                type: "POST",
                success: function(response) {

                    if (response.success == true) {
                        $("#projectItemFrom")[0].reset();
                        $('#ProjectitemForm').modal('hide');
                        Toast.fire({
                            type: 'success',
                            title: response.msg,
                        });
                        ResetFormPriv();
                        loadPrivTable($("#hiddenProjectId").val());
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



        //get all role
        getProject();

        // PARENT NAV ROUTE
        $.ajax({
            url: "{{ route('lookup.chlid.project-item') }}",
            type: "GET",
            success: function(response) {
                console.log(response)
                var html = '<option value=""> choose a lookup child</option>';
                if (response.length > 0) {
                    for (let i = 0; i < response.length; i++) {
                        html += '<option value="' + response[i]['id'] + '">' + response[i]['name'] + '</option>';
                    }
                }

                $("#item_type").html(html);
            }

        });

    });

    //get all role
    function getProject() {
        $.ajax({
            url: "{{ route('all.project') }}",
            type: "GET",
            success: function(response) {
                var data = JSON.stringify(response.data)
                var res = JSON.parse(data)
                var html = '';
                if (res.length > 0) {
                    for (let i = 0; i < res.length; i++) {
                        html += '<li><div class="row"><div class="col-sm-8 col-lg-8 col-8 text-center"> ' +
                            '<a class="list-group-item list-group-item-action d-flex align-items-center selectedItem" href="javascript:void(0)" onclick="loadPrivTable(' + res[i].id + ')">' +
                            '<span class="font-weight-bold">' + res[i].name + '</span></a></div>' +
                            '<div class="col-sm-4 col-lg-4 col-4 mt-4 ">' +
                            '<img src="/assets/images/users/project/' + res[i].photo + '" alt="Thumbnail" class="img-thumbnail">' + '</div>'
                        '</li>';
                    }
                }
                // console.log(html)
                $("#projectList").html(html);
            }

        });
    }

    //    get privilege data
    function loadPrivTable(id) {

        $("#privilege-table").show();
        $(".hiddenTitle").hide();
        $(".hiddenImage").hide();
        $(".showTitle").show();

        $("#hiddenProjectId").val(id);
        var header = document.querySelector("#projectList").querySelectorAll("li");

        header.forEach(element => {
            element.addEventListener("click", function() {
                header.forEach(nav => nav.classList.remove("active"))
                this.classList.add("active")
            });
        });


        $('#privilege-table').DataTable({
            "ajax": {
                "url": "{{route('show.project-item')}}",
                "type": "GET",
                "data": {
                    "project_id": id
                }
            },
            columns: [
                // {
                //     "data": "id",
                //     "class": "text-center"
                // },
                {
                    "data": "name"
                },
                {
                    "data": "item_position"
                },
                {
                    "data": "item_side"
                },
                {
                    data: 'price',
                    render: function(data, type, row) {
                        var formattedAmount = parseFloat(data).toLocaleString();
                        return '৳ ' + formattedAmount; // Add currency sign before the formatted amount
                    }
                },
                {
                    "data": null,
                    "sortable": false,
                    "class": "text-center",
                    "render": function(data, type, full) {
                        $(".target-element").html(full['projectName']);
                        $("#projectItem_id").html(full['id']);
                        return "<button class='btn btn-warning btn-sm btn-edit' data-target='#ProjectitemForm' data-toggle='modal' data-toggle='Edit Project' data-original-title='Edit Project' onclick='getEditProjectItem(" + full['id'] + ")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteProjectItem(" + full['id'] + ")'>Delete</button>";
                    }
                }
            ],
            "paging": true,
            // "stateSave": true,
            "bDestroy": true
        });

    }
    // edit option
    function getEditProjectItem(id) {

        $.ajax({
            url: "{{ url('project-item-edit') }}/" + id,
            type: "GET",
            success: function(response) {

                $("#projectItem_id").val(response.id);
                $("#name").val(response.name);
                $("#item_position").val(response.item_position);

                $("#item_side").val(response.item_side);

                $("#price").val(response.price);
                $("#item_type").val(response.item_type);

                // $("#lookupparent").val(response.parent).change();

            }

        });
    }
    //    DELETE OPTION
    function getDeleteProjectItem(id) {
        var result = confirm("Are you sure to delete?");
        if (result) {
            $.ajax({
                url: "{{ url('project-item-delete') }}/" + id,
                type: "DELETE",
                success: function(response) {

                    if (response.success == true) {
                        Toast.fire({
                            type: 'success',
                            title: response.msg,
                        });
                        $('#privilege-table').DataTable().ajax.reload();
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