<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expensescategory;
use App\Models\Project;
use App\Models\Projectitem;
use App\Models\Expenses;

use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    public function ExpensesIndex(){

        return view('admin.Expenses.index');
      }

      public function ExpensesCategory(){
        $ExpensesName = Expensescategory::get();
         return response()->json($ExpensesName, 200);

      }

      public function getProject(){
        $getAllproject =Project::get();
        return response()->json($getAllproject, 200);

      }

      public function getItem($project){
        $pojectItems = Projectitem::where('project_id', $project)->get();
        return response()->json($pojectItems, 200);
      }

      public function allExpenses(){
        $getAllexpenses = Expenses::select(
            'expenses.*',
            'expensescategories.name as expenses_category_name',
            'expensescategories.category_type',
            'projects.name as project_name',
            'projectitems.name as item_name'
        )
        ->leftJoin('projects', 'expenses.project_id', '=', 'projects.id')
        ->leftJoin('expensescategories', 'expenses.category_id', '=', 'expensescategories.id')
        ->leftJoin('projectitems', 'expenses.item_id', '=', 'projectitems.id')
        ->get();

        return response()->json(['data' => $getAllexpenses], 200);
    }


    // public function editExpenses($id){
    //     $expense = Expenses::select('expenses.*', 'projects.name as project_name', 'projectitems.name as item_name')
    //         ->leftJoin('projects', 'expenses.project_id', '=', 'projects.id')
    //         ->leftJoin('projectitems', 'expenses.item_id', '=', 'projectitems.id')
    //         ->where('expenses.id', $id)
    //         ->first();

    //     if ($expense) {
    //         return response()->json($expense, 200);
    //     } else {
    //         return response()->json(['error' => 'Expense not found'], 404);
    //     }
    // }
    public function editExpenses($id){
        $expenses = Expenses::findOrFail($id);
        return response()->json($expenses,200);
    }

    public function deleteExpenses($id){
        $expenses = Expenses::findOrFail($id);
        $expenses->delete();
        return response()->json([
            'msg'=>'expenses data deleted',
            'success'=>true
        ],200);
    }


      public function addExpenses(Request $request)
    {
        $expenses_id = $request->hiddenexpensesId;

        if ($expenses_id == 0) {
            $expenses = Expenses::create([
                'category_id' => $request->category_id,
                'project_id' => $request->project_id,
                'item_id' => $request->item_id,
                'amount' => $request->amount,
                'note' => $request->note,



            ]);

            return response()->json([
                'msg' => 'Expenses stored successfully',
                'user' => $expenses,
                'success' => true,
            ], 200);
        } else {
            $expenses = Expenses::findOrFail($expenses_id);
            $expenses->category_id = $request->category_id;
            $expenses->project_id = $request->project_id;
            $expenses->item_id = $request->item_id;
            $expenses->amount = $request->amount;
            $expenses->note = $request->note;


            $expenses->update();

            return response()->json([
                'msg' => 'Expenses updated successfully',
                'user' => $expenses,
                'success' => true,
            ], 200);
        }
    }
}
