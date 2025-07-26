<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if (Auth::check()) {
            $role = Auth::user()->role; // Retrieve the role of the authenticated user
            if ('admin' === $role) {
                return $next($request);
            }
            abort(401);
            
        


        }
        abort(401);
    }
    
}