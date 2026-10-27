<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


         if (Auth::check() && Auth::user()->type=='admin') 
        { 
                return redirect(route('admin.index'));
        }

         if (Auth::check() && Auth::user()->type=='worker') 
        { 
                return redirect(route('worker.index'));
        }

         if (Auth::check() && Auth::user()->type=='user') 
        { 
                return redirect(route('user.index'));
        }

           if (Auth::check() && Auth::user()->type=='service_provider') 
        { 
                return redirect(route('service-provider.index'));
        }


        
        return $next($request);
    }
}
