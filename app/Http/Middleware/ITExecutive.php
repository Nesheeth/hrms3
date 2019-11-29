<?php

namespace App\Http\Middleware;

use Closure;

class ITExecutive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
     if(\Auth::check()){
       if(\Auth::user()->is_active == 0){
        \Auth::logout();
        return  redirect('/login');
    }
    if(\Auth::user()->role != 5){
        return  redirect('/login');
    }
}else{
    return  redirect('/login');
}
return $next($request);
}
}
