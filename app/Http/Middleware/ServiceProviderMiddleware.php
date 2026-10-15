<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class ServiceProviderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check() && Auth::user()->type=='user') 
        { 
                return redirect(route('user.index'));
        }

          if (Auth::check() && Auth::user()->type=='worker') 
        { 
                return redirect(route('worker.index'));
        }

         if (Auth::check() && Auth::user()->type=='staff') 
        { 
                return redirect(route('staff.index'));
        }

        if (Auth::check() && Auth::user()->type=='admin') 
        { 
                return redirect(route('admin.index'));
        }


        return $next($request);
    }
}
