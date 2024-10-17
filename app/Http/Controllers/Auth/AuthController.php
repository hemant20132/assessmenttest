<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;
use App\Models\User;
use Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    //
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) 
        {
            User::where('email', $request->email)->update(['remember_token'=>Str::random(40)]);
            return response()->json(["status"=>200, "message"=>"Login Success."]);  
        }
        else
        {
            return response()->json(["status"=>"error", "message"=>"Login Error."]);  
        }
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required|date',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validated)
        {
                $user=new User();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->gender = $request->gender;
                $user->password = Hash::make($request->password);
                $user->date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
                $user->email = $request->email;
        
                if ($user->Save())
                {
                    return response()->json(['status'=>200 , 'message'=>'Register Create Success']);
                }
                else
                {
                    return response()->json(['status'=>'Error' , 'message'=>'Error Creating Register.']);
                }

        }
        else
        {
            return response()->json(['status'=>422 , 'message'=>'Validation Error']);
        }
    }

    public function logout()
    {
        if (Auth::logout())
        {
           Session::Flush();
            return response()->json(['status'=>200, 'message'=>"Logout Success"]);
        }
        else
        {
           return response()->json(['status'=>"error", 'message'=>"Logout Error"]);
        }
    }


}
