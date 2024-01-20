<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expensescategory;
use App\Models\Project;
use App\Models\Projectitem;
use App\Models\Expenses;
use Carbon\Carbon;
class ExpensesReportController extends Controller
{
    //
    public function ExpensesReportIndex(){

        return view('admin.Expenses_Report.index');
    }

    public function ReportExpensesCategory(){
        $ExpensesName = Expensescategory::get();
         return response()->json($ExpensesName, 200);

      }


    public function FilterExpenses(Request $request) {
        $expenseId = $request->input('expense_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Expenses::select(
            'expenses.*',
            'expensescategories.name as expenses_category_name',
            'expensescategories.category_type',
            'projects.name as project_name',
            'projectitems.name as item_name'
        )
        ->leftJoin('projects', 'expenses.project_id', '=', 'projects.id')
        ->leftJoin('expensescategories', 'expenses.category_id', '=', 'expensescategories.id')
        ->leftJoin('projectitems', 'expenses.item_id', '=', 'projectitems.id');

        if (!empty($expenseId)) {
            // Filter by category if $expenseId is provided
            $query->where('expenses.category_id', $expenseId);
        }

        if (!empty($startDate) && !empty($endDate)) {
            // Parse and convert dates to Y-m-d format
            $startDateFormatted = Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
            $endDateFormatted = Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');

            // Filter by date range if both start and end dates are provided
            $query->whereDate('expenses.created_at', '>=', $startDateFormatted)
                  ->whereDate('expenses.created_at', '<=', $endDateFormatted);
        }

        $getFilteredExpenses = $query->get();

        return response()->json(['data' => $getFilteredExpenses], 200);
    }



}
