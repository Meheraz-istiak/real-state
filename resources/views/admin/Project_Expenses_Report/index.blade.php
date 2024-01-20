@extends('admin.main')
@section('title','Project Expenses Report')
@section('css')
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
    <h1 class="page-title"> Project Expenses Report</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Project Expenses Report</li>
    </ol>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-md-3 wrap-input100 validate-input">
                            <select class="form-control" name="project_name" id="project_name">
                                <option value="">Project</option>
                            </select>
                        </div>
                        <div class="col-md-3 wrap-input100 validate-input">
                            <select class="form-control" name="project_item_name" id="project_item_name">
                                <option value="">Item</option>
                                <option value="1">All</option>

                            </select>
                        </div>


                        <button class="btn btn-info" id="filter-button">Filter</button>
                        <button class="btn btn-info ml-2" id="filter-clear">Clear</button>

                    </div>
                </div>

            </div>
            <div class="card-body">
                <table id="project-expenses-report-table" class="table table-hover dataTable table-striped width-full">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Project Name </th>
                            <th>Item</th>
                            <th>Note</th>
                            <th>Amount</th>

                        </tr>
                    </thead>
                    <tbody id="all-lookups">

                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- COL END -->

</div>

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
    $(document).ready(function() {

        $.ajax({
            url: "{{ route('project.Name') }}",
            type: "GET",
            success: function(response) {
                var html = '<option value="">Project</option>';
                if (response.length > 0) {
                    for (let i = 0; i < response.length; i++) {
                        html += '<option value="' + response[i]['id'] + '">' + response[i]['name'] + '</option>';
                    }
                }

                $("#project_name").html(html);
            }

        });


        $.ajax({
            url: "{{ route('project.item.Name') }}",
            type: "GET",
            success: function(response) {
                var html = '<option value="">Item</option>' +
                    '<option value="1">All</option>';

                if (response.length > 0) {
                    for (let i = 0; i < response.length; i++) {
                        html += '<option value="' + response[i]['id'] + '">' + response[i]['name'] + '</option>';
                    }
                }

                $("#project_item_name").html(html);
            }

        });


        $('#filter-button').on('click', function() {
            var selectedProjectExpenseId = $('#project_name').val();
            var selectedItemExpenseId = $('#project_item_name').val();


            // Check which filter is being applied
            var isCategoryProjectFilter = selectedProjectExpenseId !== '';
            var isCategoryItemFilter = selectedItemExpenseId !== '';

            if (isCategoryProjectFilter || isCategoryItemFilter) {

                if ($.fn.DataTable.isDataTable('#project-expenses-report-table')) {
                    $('#project-expenses-report-table').DataTable().destroy();
                }
                // Initialize DataTable outside the AJAX request
                var dataTable = $('#project-expenses-report-table').DataTable({
                    columns: [

                        {
                            "data": null,
                            "sortable": false,
                            "class": "text-left padding-5",
                            "render": function(data, type, full) {
                                var created_at = new Date(data.created_at).toLocaleDateString('en-us', {
                                    year: "numeric",
                                    month: "short",
                                    day: "numeric"
                                })
                                return '<p>' + created_at + '</p>';
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
                            data: 'amount',
                            render: function(data, type, row) {
                                var formattedAmount = parseFloat(data).toLocaleString();
                                return '৳ ' + formattedAmount;
                            }
                        },
                    ]
                });

                // Make an AJAX request to filter expenses
                $.ajax({
                    url: '/filter-project-expenses',
                    type: 'GET',
                    data: {
                        project_expense_id: selectedProjectExpenseId,
                        item_expense_id: selectedItemExpenseId,
                    },
                    success: function(data) {
                        // Clear existing data in the DataTable
                        dataTable.clear();

                        // Add new data to the DataTable
                        if (data && data.data.length > 0) {
                            dataTable.rows.add(data.data).draw();
                        } else {
                            // Handle empty data or show a message
                            console.log('No data found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error if necessary
                        console.error(error);
                    }
                });



            }


        });
        $('#filter-clear').on('click', function() {
            // Clear filter inputs
            $('#project_name').val('');
            $('#project_item_name').val('');

            // Check if DataTable is initialized, then clear and redraw it
            if ($.fn.DataTable.isDataTable('#project-expenses-report-table')) {
                var dataTable = $('#project-expenses-report-table').DataTable();

                // Clear existing data in the DataTable
                dataTable.clear().draw();

                // Redraw the DataTable to reset the table with empty data
                dataTable.rows.add([]).draw();
            }
        });


    });
</script>

@endsection