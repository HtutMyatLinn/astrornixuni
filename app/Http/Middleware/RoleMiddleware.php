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
        $role = Auth::user()->role->role;

        if ($role != 'Admin') {
            return redirect('admin/dashboard');
        } elseif ($role != 'Marketing Manager') {
            return redirect('marketingmanager/dashboard');
        } elseif ($role != 'Marketing Coordinator') {
            return redirect('marketingcoordinator/dashboard');
        } elseif ($role != 'Student') {
            return redirect('student/dashboard');
        } else {
            return redirect('/');
        }
        return $next($request);
    }
}
