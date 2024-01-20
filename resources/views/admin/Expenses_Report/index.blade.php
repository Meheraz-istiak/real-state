@extends('admin.main')
@section('title','Expenses Report')
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
    <h1 class="page-title">Expenses Report</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Expenses Report</li>
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
                            <select class="form-control" name="expenses_filter" id="expenses_filter">
                                <option value="">Expense</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" name="start-date" id="start_date" placeholder="MM/DD/YYYY" type="text">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group">
                                <label></label>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" name="end-date" id="end_date" placeholder="MM/DD/YYYY" type="text">
                            </div>
                        </div>


                        <button class="btn btn-info" id="filter-button">Filter</button>
                        <button class="btn btn-info ml-2" id="filter-clear">Clear</button>
                    </div>
                </div>
                <!-- <div class="col-lg-6 text-right">
                    <button class="btn btn-info" data-target="#ExpensesForm" data-toggle="modal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <span class="hidden-xs">Add Expenses</span>
                    </button>
                </div> -->
            </div>
            <div class="card-body">
                <table id="expenses-category-table" class="table table-hover dataTable table-striped width-full">
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
            url: "{{ route('Report.Expenses.category') }}",
            type: "GET",
            success: function(response) {
                var html = '<option value="">Expense</option>';
                if (response.length > 0) {
                    for (let i = 0; i < response.length; i++) {
                        html += '<option value="' + response[i]['id'] + '">' + response[i]['name'] + '</option>';
                    }
                }

                $("#expenses_filter").html(html);
            }

        });


        $('#filter-button').on('click', function() {
            var selectedExpenseId = $('#expenses_filter').val();
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();

            // Check which filter is being applied
            var isCategoryFilter = selectedExpenseId !== '';
            var isDateRangeFilter = startDate !== '' && endDate !== '';

            if (isCategoryFilter || isDateRangeFilter) {

                if ($.fn.DataTable.isDataTable('#expenses-category-table')) {
                    $('#expenses-category-table').DataTable().destroy();
                }
                // Initialize DataTable outside the AJAX request
                var dataTable = $('#expenses-category-table').DataTable({
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
                            data: 'expenses_category_name'
                        },
                        {
                            data: 'project_name'
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
                    url: '/filter-expenses',
                    type: 'GET',
                    data: {
                        expense_id: selectedExpenseId,
                        start_date: startDate,
                        end_date: endDate
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
            // Clear input fields
            $('#start_date').val('');
            $('#end_date').val('');
            $('#expenses_filter').val('');

            if ($.fn.DataTable.isDataTable('#expenses-category-table')) {
                var dataTable = $('#expenses-category-table').DataTable();

                // Clear existing data in the DataTable
                dataTable.clear().draw();

                // Redraw the DataTable to reset the table with empty data
                dataTable.rows.add([]).draw();
            }


        });

    });
</script>

@endsection