<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LookUp;
use App\Models\Project;
use App\Models\Projectitem;
use Illuminate\Support\Facades\DB;


class ProjectItemController extends Controller
{
    public function projectItemIndex()
    {

        return view('admin.project_item.index');
    }

    public function projectData()
    {

        $projectData = Project::select('id', 'name','photo')->get();

        return response()->json(['data' => $projectData], 200);
    }

    public function getLookupChild()
    {
        $lookup = LookUp::where('parent', config('lookup.lookup_item.Project_Item_Type'))->get();

        return response()->json($lookup, 200);
    }

    public function projectItemShow(Request $request)
    {

        $project_id = $request->project_id;


        $projectItem = DB::select("SELECT projectitems.*, projects.name as projectName
                                 FROM projectitems
                                 INNER JOIN projects ON projectitems.project_id = projects.id
                                 WHERE projectitems.project_id = $project_id");

        // dd($privilege);
        return response()->json(['data' => $projectItem], 200);
    }
    public function editProjectItem($id){
        $Projectitem = Projectitem::findOrFail($id);
        return response()->json($Projectitem,200);
    }


    public function deleteProjectItem($id)
    {
        // dd($id);
        $Projectitem = Projectitem::findOrFail($id);
        $Projectitem->delete();
        return response()->json([
            'msg' => 'Projectitem deleted',
            'success' => true
        ], 200);
    }


    public function Store(Request $request)
    {
        //  dd($request);
        $project_Id = $request->projectItem_id;

        if ($project_Id == 0) {
            $projectItem = Projectitem::create([
                'project_id' => $request->project_id,
                'name' => $request->name,
                'item_position' => $request->item_position,
                'item_side' => $request->item_side,

                'price' => $request->price,

                'item_type' => $request->item_type,



            ]);
            if ($projectItem != null) {
                return response()->json([
                    'msg' => 'Item data store successfully.',
                    'success' => true
                ], 200);
            }
        } else {
            $projectItem = Projectitem::findOrFail($project_Id);
            $projectItem->project_id = $request->project_id;
            $projectItem->name = $request->name;
            $projectItem->item_position = $request->item_position;
            $projectItem->item_side = $request->item_side;
            $projectItem->price = $request->price;
            $projectItem->item_type = $request->item_type;


            $projectItem->update();

            if ($projectItem != null) {
                return response()->json([
                    'msg' => 'projectItem data updated successfully',
                    'success' => true
                ], 200);
            }
        }
    }
}
