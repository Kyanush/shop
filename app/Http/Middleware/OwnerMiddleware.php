<?php

namespace App\Http\Middleware;


use Closure;
use Redirect;

class OwnerMiddleware
{

    public function handle($request, Closure $next, $role){
        if (!$request->user()->hasRole($role)) {
            //return response()->json('У вас нет прав!', 403);
            return Redirect::back();
        }
        return $next($request);
    }

}
