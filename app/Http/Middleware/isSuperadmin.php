<?php

namespace App\Http\Middleware;

use App\Models\Accounts;
use Closure;
use Auth;
use JWTAuth;
use Illuminate\Http\Request;

class isSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        try {
            $jwt = JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $jwt = false;
        }


        if (Auth::user()->role_id == 1) {
            return $next($request);
        } else {
            return response('Unauthorized.', 401);
        }
    }


    //     $account = Accounts::with('roles')->where('id', Auth()->user()->id)->first();
    //     if ($account->role_id == 1) {
    //         return $next($request);
    //         // return 'asdasdasd';
    //     }
    //     return response('Unauthorized.', 401);
    // }
}
