<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                //  return redirect(RouteServiceProvider::HOME);
                $role = Auth::user()->role;

                switch ($role) {
                    case 'Admin':
                        return redirect('/admin/home');
                        break;
                    case 'Student':
                        return redirect('/student/home');
                        break;
                    case 'Tutor':
                        return redirect('/tutor/home');
                        break;
                    case 'Vendor':
                        return redirect('/vendor/home');
                        break;
                    case 'Branch':
                        return redirect('/branch/home');
                        break;
                    case 'Publisher':
                        return redirect('/publisher/home');
                        break;
                    case 'Team':
                        return redirect('/team/home');
                        break;
                    default:
                        return redirect('/');
                        break;
                }

            }
        }

        return $next($request);
    }
}
