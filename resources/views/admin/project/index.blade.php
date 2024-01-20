@extends('admin.main')
@section('title','project')
@section('css')
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/multipleselect/multiple-select.css')}}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!-- PAGE-HEADER -->
<div>
    <h1 class="page-title">Dashboard</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">project</li>
    </ol>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<!-- ROW-4 OPEN -->
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title ">Projects</h3>
            </div>
            <div class="">
                <div class="d-flex table-responsive p-3">
                    <div class="mr-2">
                        <button class="btn btn-primary btn-sm fs-13" data-target="#project" data-toggle="modal" ;><i class="mdi mdi-plus-circle-outline"></i>Add</button>
                    </div>
                </div>
                <div class="modal fade" id="project" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Project</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ResetProjectForm();">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="projectFrom" name="projectFrom" autocomplete="off" enctype="multipart/form-data">
                                    @csrf
                                    <div class="container-fluid">
                                        <input type="hidden" name="hiddenProjectId" id="hiddenProjectId" value="0">
                                        <div class="row mt-3">
                                            <label class="col-md-3 control-label">Name :</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="write your project name">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <label class="col-md-3 control-label">Location :</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="location" id="location" placeholder="write your project location">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <label class="col-md-3 control-label">Start date :</label>
                                            <div class="col-md-9">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar"></i>
                                                    </div><input class="form-control fc-datepicker" name="start_date" id="start_date" placeholder="MM/DD/YYYY" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <label class="col-md-3 control-label">End date :</label>
                                            <div class="col-md-9">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar"></i>
                                                    </div><input class="form-control fc-datepicker" name="end_date" id="end_date" placeholder="MM/DD/YYYY" type="text">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 mb-3">
                                            <label class="col-md-3 control-label">Project-type:</label>
                                            <div class="col-md-9 wrap-input100 validate-input">
                                                <select class="form-control" name="project_type" id="project_type">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <label class="col-md-3 control-label">Boq :</label>
                                            <div class="col-md-9">
                                                <input type="file" accept=".xls, .xlsx" class="form-control" name="excel" id="excel" placeholder="give excel name">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <label class="col-md-3 control-label">Photo :</label>
                                            <div class="col-md-9">
                                                <input type="file" class="form-control" name="photo" id="photo" accept="image/*" placeholder="give photo">
                                            </div>
                                            <label class="col-md-3 control-label">Preview Photo:</label>
                                            <div class="col-md-9" id="imagePreview"></div>
                                        </div>
                                        <hr />
                                        <div class="model-footer text-right">
                                            <label class="wc-error pull-left" id="form_error"></label>
                                            <input type="submit" name="submit" value="Submit" class="btn btn-primary mr-3" id="btnLookupForm">
                                            <button type="button" class="btn btn-default btn-outline" data-dismiss="modal" aria-label="Close" onclick="ResetProjectForm();">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="project-table" class="table table-hover dataTable table-striped width-full">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>location</th>
                                <th>photo</th>
                                <th>start date</th>
                                <th>end date</th>
                                <th>project type</th>
                                <th>BOQ</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="all-lookups">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- COL END -->
</div>
<!-- ROW-4 CLOSED -->


@endsection

@section('js')

<script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/date-picker/spectrum.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/multipleselect/multiple-select.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/multipleselect/multi-select.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/time-picker/toggles.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
<script type="text/javascript">
    function ResetProjectForm() {
        $('#projectFrom')[0].reset();
        $('#hiddenProjectId').val('').change();
        $('#imagePreview').html('');
        $('#excel').val('')
    }

    // input photo preview image
    $(document).ready(function() {
        // Event listener for file input change
        $("#photo").change(function() {
            // Get selected file
            var file = this.files[0];
            // Check if the file is an image
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                // Read the image file as a data URL
                reader.onload = function(e) {
                    // Display the image preview
                    $('#imagePreview').html('<img src="' + e.target.result + '" alt="Image Preview" style="max-width: 100%; max-height: 84px; padding-top:5px;">');
                };
                reader.readAsDataURL(file); // Read the image file
            } else {
                // Clear the image preview if the selected file is not an image
                $('#imagePreview').html('Invalid File. Please select an image.');
            }
        });
    });

    // submit modal form
    $('#projectFrom').on("submit", function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        formData.append('photo', $("#photo")[0].files[0]);
        formData.append('excel', $("#excel")[0].files[0]);

        $.ajax({
            url: "{{ route('store.project') }}",
            data: formData,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(response) {
                $('#project').modal('hide');
                $("#projectFrom")[0].reset();
                Toast.fire({
                    type: 'success',
                    title: response.msg,
                });
                ResetProjectForm();
                $('#project-table').DataTable().ajax.reload();
            },
            error: function(error) {
                Toast.fire({
                    type: 'error',
                    title: 'Something Error Found, Please try again.',
                });
            }
        });
    });

    // datatable
    $(document).ready(function() {
        $('#project-table').DataTable({
            ajax: "{{ route('show.project') }}",
            columns: [
                // {
                //     data: 'id'
                // },
                {
                    data: 'name'
                },
                {
                    data: 'location'
                },
                {
                    data: 'photo',
                    render: function(data, type, full, meta) {
                        return '<img src="/assets/images/users/project/' + data + '" alt="Image" width="50" height="50" />';
                    }
                },
                {
                    "data": null,
                    "sortable": false,
                    "class": "text-left padding-5",
                    "render": function(data, type, full) {
                        var start_date = new Date(data.start_date).toLocaleDateString('en-us', {
                            year: "numeric",
                            month: "short",
                            day: "numeric"
                        })
                        return '<p>' + start_date + '</p>';
                    }
                },
                {
                    "data": null,
                    "sortable": false,
                    "class": "text-left padding-5",
                    "render": function(data, type, full) {
                        var end_date = new Date(data.end_date).toLocaleDateString('en-us', {
                            year: "numeric",
                            month: "short",
                            day: "numeric"
                        })
                        return '<p>' + end_date + '</p>';
                    }
                },
                {
                    data: 'childName'
                },

                {
                    data: 'excel',
                    render: function(data, type, full, meta) {
                        return '<a href="/assets/images/users/project/excel/' + data + '"><i class="fa fa-download" aria-hidden="true"></i></a>';

                    }
                },
                {
                    "data": null,
                    "sortable": false,
                    "class": "text-left padding-5",
                    "render": function(data, type, full) {
                        return "<button class='btn btn-warning btn-sm btn-edit' data-target='#project' data-toggle='modal' data-toggle='Edit Project' data-original-title='Edit Project' onclick='getEditProject(" + full['id'] + ")'>Edit</button> <button class='btn btn-danger btn-sm btn-del' onclick='getDeleteProject(" + full['id'] + ")'>Delete</button>";
                    }
                },
            ],
        });

        // PARENT NAV ROUTE
        $.ajax({
            url: "{{ route('lookup.chlid.project') }}",
            type: "GET",
            success: function(response) {
                // console.log(response)
                var html = '<option value=""> choose one </option>';
                if (response.length > 0) {
                    for (let i = 0; i < response.length; i++) {
                        html += '<option value="' + response[i]['id'] + '">' + response[i]['name'] + '</option>';
                    }
                }
                $("#project_type").html(html);
            }
        });
    });
    // edit option

    function getEditProject(id) {
        $.ajax({
            url: "{{ url('project-edit') }}/" + id,
            type: "GET",
            success: function(response) {
                // Format date using JavaScript Date object
                var startDate = new Date(response.start_date);
                var endDate = new Date(response.end_date);
                // Format date to YYYY-MM-DD format
                var formattedStartDate = startDate.toISOString().split('T')[0];
                var formattedEndDate = endDate.toISOString().split('T')[0];
                // Set formatted values to input fields
                $("#hiddenProjectId").val(response.id);
                $("#name").val(response.name);
                $("#location").val(response.location);
                $("#start_date").val(formattedStartDate);
                $("#end_date").val(formattedEndDate);
                $("#project_type").val(response.project_type);
                // Set file names to the span elements
                $("#excel").text(response.excel);
                var baseUrl = "{{ asset('assets/images/users/project/') }}/";
                // Set image preview using <img> tag
                if (response.photo) {
                    $("#imagePreview").html('<img src="' + baseUrl + response.photo + '" alt="Image Preview" style="max-width: 100%; max-height: 84px; padding-top:5px;">');
                } else {
                    $("#imagePreview").html('No Image Available');
                }
            }
        });
    }

    //    DELETE OPTION
    function getDeleteProject(id) {
        var result = confirm("Are you sure to delete?");
        if (result) {
            $.ajax({
                url: "{{ url('project-delete') }}/" + id,
                type: "DELETE",
                success: function(response) {
                    if (response.success == true) {
                        Toast.fire({
                            type: 'success',
                            title: response.msg,
                        });
                        $('#project-table').DataTable().ajax.reload();
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