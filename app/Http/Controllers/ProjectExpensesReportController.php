<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Projectitem;
use App\Models\Expenses;
use Illuminate\Support\Facades\DB;

class ProjectExpensesReportController extends Controller
{
    //
    public function ProjectExpensesReportIndex()
    {

        return view('admin.Project_Expenses_Report.index');
    }

    public function ProjectName()
    {
        $ProjectName = Project::get();
        return response()->json($ProjectName, 200);
    }

    public function ProjectItemName()
    {
        $ProjectItemName = Projectitem::get();
        return response()->json($ProjectItemName, 200);
    }


    public function FilterProjectExpenses(Request $request)
    {
        $projectId = $request->input('project_expense_id');
        $itemId = $request->input('item_expense_id');


        $query = Expenses::select(
            'expenses.*',
            'projects.name as project_name',
            'projectitems.name as item_name',
            'projectitems.price'

        )
            ->leftJoin('projects', 'expenses.project_id', '=', 'projects.id')

            ->leftJoin('projectitems', 'expenses.item_id', '=', 'projectitems.id');


        if (!empty($projectId)) {
            // Filter by category if $expenseId is provided
            $query->where('expenses.project_id', $projectId);
        }

        if (!isset($itemId) || $itemId == 1) {
            // If $itemId is 1 or not provided, do not apply item_id filter
            $query->get();
        } else {
            // If $itemId is provided and not equal to 1, apply item_id filter
            $query->where('expenses.item_id', $itemId);
        }
        $getFilteredExpenses = $query->get();

        return response()->json(['data' => $getFilteredExpenses], 200);
    }
}
