<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        $user = Session::get('user');

        // Not logged in
        if (!$user) {
            return redirect('/login');
        }

        // Wrong role
        if ($user['role'] != $role) {
            return redirect('/login')
                ->with('error', 'Unauthorized Access');
        }
        
        return $next($request);
    }
}
