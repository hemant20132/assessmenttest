<?php

namespace App\Http\Controllers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function UserCreate(Request $request)
    {
            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'date_of_birth' => 'required|date',
                'email' => 'required|email',
                'password'=>'required'
            ]);
            if ($validated)
            {
                    $user=new User();
                    $user->first_name = $request->first_name;
                    $user->last_name = $request->last_name;
                    $user->gender = $request->gender;
                    $user->date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
                    $user->email = $request->email;
                    $user->password = Hash::make($request->password);
                    
                    if ($user->save())
                    {
                        return response()->json(['status'=>200 , 'message'=>'New User Create Success.']);
                    }
                    else
                    {
                        return response()->json(['status'=>'Error' , 'message'=>'Error in Creating New User.']);
                    }

            }
            else
            {
                return response()->json(['status'=>422 , 'message'=>'Validation Error']);
            }

    }

    public function GetSingleUser(Request $request)
    {
        $id=$request->id;
        $user=User::findOrFail($id);
        if ($user)
        {
            return response()->json(['status'=>200 , 'response'=>$user]);
        }
        else
        {
            return response()->json(['status'=>'NotFound' , 'message'=>'User Not Found']);
        }

    }

    public function GetAll(Request $request)
    {
        if (isset($request->first_name) and isset($request->gender) and isset($request->date_of_birth))
        {    
            $user=User::where('first_name', $request->first_name)->
                    where('gender', $request->gender)->
                    where('date_of_birth', Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d'))->get();
        }
        else
        {
            $user = User::all();
        }

        if ($user)
        {
             return response()->json(['status'=>200 , 'response'=>$user]);
        }
        else
        {
            return response()->json(['status'=>'NotFound' , 'message'=>'No Records Found']);
        }
    }

    public function Update($id, Request $request)
    {
        
        $user=User::find($id);
        if (isset($request->first_name))
        {
            $user->first_name = $request->first_name;
        }
        if (isset($request->last_name))
        {
            $user->last_name = $request->last_name;
        }
        if (isset($request->gender))
        {
            $user->gender = $request->gender;
        }
        if (isset($request->date_of_birth))
        {
            $user->date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
        }
        if (isset($request->email))
        {
            $user->email = $request->email;
        }   

        if ($user->Save())
        {
            return response()->json(['status'=>200 , 'message'=>'User Update Success.']);
        }
        else
        {
            return response()->json(['status'=>'error' , 'message'=>'User Update Error.']);
        }

    }

    public function Delete($id)
    {
        if ($id) 
        {
            $user=User::find($id);
            if($user->delete())
            {
                return response()->json(['status'=>200 , 'message'=>'User Delete Success.']);
            }
            else
            {
                return response()->json(['status'=>'error' , 'message'=>'User Delete Error.']);
            }
        
        }   
        else
        {
            return response()->json(['status'=>'error' , 'message'=>'please enter delete id.']);
        }    
    }

    
}
