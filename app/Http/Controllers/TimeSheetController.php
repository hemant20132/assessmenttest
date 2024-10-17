<?php

namespace App\Http\Controllers;
use App\Models\TimeSheet;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeSheetController extends Controller
{
    //
    public function CreateTimeSheet(Request $request)
    {
        $validated = $request->validate([
                'task_name' => 'required',
                'date' => 'date|required',
                'hours' => 'required',
                'user_id' => 'required',
                'project_id' => 'required'
        ]);

        if ($validated)
        {
            $timesheet= new TimeSheet();
            $timesheet->task_name = $request->task_name;
            $timesheet->date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $timesheet->hours = $request->hours;
            $timesheet->user_id = $request->user_id;
            $timesheet->project_id = $request->project_id;
            
            if ($timesheet->save())
            {
                return response()->json(['status'=>200, 'message'=>'Create Timesheet Success.']);
            }
            else
            {
                return response()->json(['status'=>'error', 'message'=>'Create Timesheet Error.']);
            }
        }
        else
        {
             return response()->json(['status'=>'422', 'message'=>'Create Timesheet Error.']);
        }

    }

    public function GetSingleTimeSheet($id)
    {
        $timesheet = TimeSheet::find($id);
        if ($timesheet)
            {
                return response()->json(['status'=>200, 'response' => $timesheet]);
            }
        else
            {
                return response()->json(['status'=>'NotFound', 'message'=>"TimeSheet Not Found."]);     
            }    
   }

   public function GetAll(Request $request)
   {
        $timesheet=TimeSheet::all();
        if ($timesheet)
            {
                return response()->json(['status'=>200, 'response' => $timesheet]);
            }
        else
            {
                return response()->json(['status'=>'NotFound', 'message'=>"TimeSheet Not Found."]);     
            }
   }

   public function Update($id, Request $request)
   {
        $timesheet=TimeSheet::find($id);
        if ($timesheet)
        {
            if (isset($request->task_name))
            {
                $timesheet->task_name = $request->task_name;
            }
            if (isset($request->date))
            {
                $timesheet->date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            }
            if (isset($request->hours))
            {
                $timesheet->hours = $request->hours;
            }
            if (isset($request->user_id))
            {
                $timesheet->user_id = $request->user_id;
            }
            if (isset($request->project_id))
            {
                $timesheet->project_id = $request->project_id;
            }
            if ($timesheet->Save())
            {
                return response()->json(['status'=>200, 'message'=>'Update Timesheet Success.']);
            }
            else
            {
                return response()->json(['status'=>'error', 'message'=>'Update Timesheet Error.']);
            }   
        }
        else
        {
            return response()->json(['status'=>'NotFound', 'message'=>"TimeSheet Not Found."]);     
        }

   }

   public function Delete($id)
   {
       if ($id) 
       {
           $timesheet=TimeSheet::find($id);
           if($timesheet->delete())
           {
               return response()->json(['status'=>200 , 'message'=>'Timesheet Delete Success.']);
           }
           else
           {
               return response()->json(['status'=>'error' , 'message'=>'Timesheet Delete Error.']);
           }
       
       }   
       else
       {
           return response()->json(['status'=>'error' , 'message'=>'please enter delete id.']);
       }    
   }


}
