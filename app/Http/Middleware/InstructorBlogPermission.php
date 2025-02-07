<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class InstructorBlogPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (get_frontend_settings('instructors_blog_permission') != 0) {
            return $next($request);
        } else {
            return redirect(route('instructor.dashboard'));
        }
    }
}
