<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProjectController extends Controller
{
    //

    public function CreateProject(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'department' => 'required',
            'user_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required',
        ]);
        if ($validated)
        {   
            $project = new Project();
            $project->name = $request->name;
            $project->department = $request->department;
            $project->user_id = $request->user_id;
            $project->start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
            $project->end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
            $project->status = $request->status;
            if ($project->Save())
                {
                    return response()->json(['status'=>200, 'message'=>'Create New Project Success.']);
                }
            else
                {    
                    return response()->json(['status'=>'Error', 'message'=>'Create New Project Error.']);
                }            
        }
        else
        {
            return response()->json(['status'=>422 , 'message'=>'Validation Error']);
        }    

    }

    public function GetSingleProject(Request $request)
    {
        $id = $request->id;
        $project = Project::find($id);
        if ($project) 
        {
            return response()->json(['status'=>200, 'response'=>$project]) ;
        }
        else
        {
            return response()->json(['status'=>'NotFound', 'message'=>'Record Not found.']) ;
        }       
    }

    public function GetAll(Request $request)
    {
        $project= Project::all();
        if ($project) 
        {
            return response()->json(['status'=>200, 'response'=>$project]) ;
        }
        else
        {
            return response()->json(['status'=>'NotFound', 'message'=>'Record Not found.']) ;
        }       
    
    }

    public function Update($id, Request $request)
    {
        $project = Project::find($id);
        if ($project)
        {
            if (isset($request->name))
            {
                $project->name = $request->name;
            }
            if (isset($request->department))
            {
                $project->department = $request->department;
            }
            if (isset($request->user_id))
            {
                $project->user_id = $request->user_id;
            }
            if (isset($request->start_date))
            {
                $project->start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
            }
            if (isset($request->end_date))
            {
                $project->end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
            }

            if ($project->Save())
            {
                return response()->json(['status'=>200, 'message'=>'Project Update Success.']) ;
            }
            else
            {
                return response()->json(['status'=>'error', 'message'=>'Project Update Error.']) ;
            }
        }
        else
        {
            return response()->json(['status'=>'NotFound', 'message'=>'Record Not found.']) ;
        }

    }

    public function Delete($id)
    {
        if ($id) 
        {
            $project=Project::find($id);
            if($project->delete())
            {
                return response()->json(['status'=>200 , 'message'=>'Project Delete Success.']);
            }
            else
            {
                return response()->json(['status'=>'error' , 'message'=>'Project Delete Error.']);
            }
        
        }   
        else
        {
            return response()->json(['status'=>'error' , 'message'=>'please enter delete id.']);
        }    
    }



}
