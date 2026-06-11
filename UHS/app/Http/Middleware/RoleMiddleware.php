<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {

        $user = Session::get('user');

        // Not logged in
        if (!$user) {
            return redirect('/login');
        }

        // Wrong role

        if (!in_array($user['role'], $roles)) {
            return redirect('/login')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}
