<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnrollCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (course_enrolled(auth()->user()->id) || course_creator(auth()->user()->id) || auth()->user()->role == 'admin') {
            return $next($request);
        } else {
            return redirect(route('home'));
        }
    }
}
