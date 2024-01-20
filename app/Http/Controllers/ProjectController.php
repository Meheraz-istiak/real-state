<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\LookUp;

use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function projectIndex()
    {
        return view('admin.project.index');
    }

    public function projectShow()
    {
        $project = DB::table('projects as l1')
            ->leftJoin('look_ups as l2', 'l1.project_type', '=', 'l2.id')
            ->select('l1.*', 'l2.name as childName')->get();

        return response()->json(['data' => $project], 200);
    }

    public function getLookupChild()
    {

        $lookup = LookUp::where('parent', config('lookup.lookup_item.Project_Type'))->get();

        return response()->json($lookup, 200);
    }

    public function Store(Request $request)
    {
        // dd($request);
        $projectid = $request->hiddenProjectId;

        $date = Carbon::now()->format('his') . rand(1000, 9999);
        $photoPath = null;
        $excelPath = null;

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $extension = $image->getClientOriginalExtension();
            $imageName = $date . '.' . $extension;
            $path = public_path('assets/images/users/project');
            $image->move($path, $imageName);
            $photoPath = $imageName;
        } else {
            $photoPath = $projectid ? Project::findOrFail($projectid)->photo : null;
        }


        $date1 = Carbon::now()->format('his') . rand(1000, 9999);
        if ($request->hasFile('excel')) {
            $excel = $request->file('excel');
            $extension = $excel->getClientOriginalExtension();
            $excelName = $date1 . '.' . $extension;
            $path = public_path('assets/images/users/project/excel');
            $excel->move($path, $excelName);
            $excelPath = $excelName;
        } else {
            $excelPath = $projectid ? Project::findOrFail($projectid)->excel : null;
        }

        if ($projectid == 0) {
            // Create a new lookup
            $project = Project::create([
                'name' => $request->name,
                'location' => $request->location,
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date)),
                'project_type' => $request->project_type,

                'photo' => $photoPath,
                'excel' => $excelPath,

            ]);

            return response()->json([
                'msg' => 'Lookup stored successfully',
                'user' => $project,
                'success' => true,
            ], 200);
        } else {
            // Update an existing lookup
            $project = Project::findOrFail($projectid);
            $project->name = $request->name;
            $project->location = $request->location;
            $project->start_date = date('Y-m-d', strtotime($request->start_date));
            $project->end_date = date('Y-m-d', strtotime($request->end_date));
            $project->project_type = $request->project_type;
            $project->photo = $photoPath;

            // Set the 'excel' field to null if $excelPath is null
            $project->excel = $excelPath;

            $project->update();

            return response()->json([
                'msg' => 'Lookup updated successfully',
                'user' => $project,
                'success' => true,
            ], 200);
        }
    }

    public function editProject($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project, 200);
    }

    public function deleteProject($id)
    {
        // Find the project by ID
        $project = Project::findOrFail($id);

        // Get the image and excel file paths from the database
        $imageFilePath = public_path('assets/images/users/project/' . $project->photo);
        $excelFilePath = public_path('assets/images/users/project/excel/' . $project->excel);

        // Check if the image file exists and delete it
        if (file_exists($imageFilePath)) {
            unlink($imageFilePath); // Delete the image file from the public directory
        }

        // Check if the excel file exists and delete it
        if (file_exists($excelFilePath)) {
            unlink($excelFilePath); // Delete the excel file from the public directory
        }

        // Delete the project record from the database
        $project->delete();

        // Return a JSON response
        return response()->json([
            'msg' => 'Project deleted',
            'success' => true
        ], 200);
    }
}
