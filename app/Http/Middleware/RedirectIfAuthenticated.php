<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

          // Ensure $user uses Spatie's HasRoles trait
if (method_exists($user, 'hasRole') && $user instanceof \Spatie\Permission\Traits\HasRoles) {
    if ($user->hasRole('superadmin')) {
        return redirect('/superadmin/dashboard');
    }
    if ($user->hasRole('admin')) {
        return redirect('/admin/dashboard');
    }
    if ($user->hasRole('usher')) {
        return redirect('/usher/dashboard');
    }
}


                // Default redirect for authenticated users without specific roles
                return redirect(RouteServiceProvider::HOME); // More consistent and configurable
            }
        }

        return $next($request);
    }
}
