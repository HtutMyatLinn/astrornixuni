<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = Auth::user()->role;

        if ($role != 'admin') {
            return redirect('admin/dashboard');
        } elseif ($role != 'arketingmanager') {
            return redirect('marketingmanager/dashboard');
        } elseif ($role != 'marketingcoordinator') {
            return redirect('marketingcoordinator/dashboard');
        } elseif ($role != 'student') {
            return redirect('student/dashboard');
        } else {
            return redirect('/');
        }
        return $next($request);
    }
}
