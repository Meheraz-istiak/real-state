<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expensescategory;
use Illuminate\Support\Facades\DB;

class ExpensesCategoryController extends Controller
{
    public function ExpensesCategoryIndex()
    {
        return view('admin.expenses_category.index');
    }

    public function allExpensesCategory()
    {
        $allexpensescategory = Expensescategory::all();
        // dd( $allexpensescategory);
        return response()->json(['data' => $allexpensescategory], 200);
    }

    public function editExpensesCategory($id)
    {
        $expenses_category = Expensescategory::findOrFail($id);
        return response()->json($expenses_category, 200);
    }

    public function deleteExpensesCategory($id)
    {
        $expenses_category = Expensescategory::findOrFail($id);
        $expenses_category->delete();
        return response()->json([
            'msg' => 'expenses category deleted',
            'success' => true
        ], 200);
    }

    public function addExpensesCategory(Request $request)
    {
        $expensescategory_id = $request->hiddenexpensescategoryId;

        if ($expensescategory_id == 0) {
            $expensescategory = Expensescategory::create([
                'name' => $request->name,
                'category_type' => $request->category_type,

            ]);

            return response()->json([
                'msg' => 'Expenses category stored successfully',
                'user' => $expensescategory,
                'success' => true,
            ], 200);
        } else {
            $expensescategory = Expensescategory::findOrFail($expensescategory_id);
            $expensescategory->name = $request->name;
            $expensescategory->category_type = $request->category_type;
            $expensescategory->update();

            return response()->json([
                'msg' => 'Expenses category updated successfully',
                'user' => $expensescategory,
                'success' => true,
            ], 200);
        }
    }
}
