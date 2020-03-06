<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class admin
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
        // if(!Auth::user()->user_type == "admin"){

        //     return $next($request);
        //     // return redirect()->back();
        //     // return view('pages.admin');
        // }
        // return redirect()->route('admin.home');

        if(!$request->user()->user_type == "admin"){
          return redirect()->guest('home');
        }
      

        // else{
        //     return redirect()->route('admin.home');
        // }

        return $next($request);
    }
}
