<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class WithAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $header = $request->header('Authorization');
        if ($header)
        {
            $token=ltrim($header,"Bearer ");
            $user=User::where('remember_token', $token)->get();
            if ($user)
                {
                    return $next($request);
                }    
                else
                {
                    return response()->json(['status'=>401 , 'message'=>'Unauthorized']);
                }
            }
        else
        {
                return response()->json(['status'=>401 , 'message'=>'Unauthorized']);
        }
      
              

    }
}
