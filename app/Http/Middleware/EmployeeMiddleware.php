<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
/*class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->emp_role === 'E') {
                return $next($request);
            } else {
                Auth::logout();
                return redirect('/login');
            }
        } else {
            Auth::logout();
            return redirect('/login');
        }
    }
}
*/
class EmployeeMiddleware
{

public function handle(Request $request, Closure $next): Response
{
    $user = session('user');

    if ($user && $user->emp_role === 'E') {
        return $next($request);
    }

    return redirect('/login');
}

}

