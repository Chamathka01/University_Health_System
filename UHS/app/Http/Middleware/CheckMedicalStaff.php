<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMedicalStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = session('user');

        if (!$user || !in_array($user['role'], ['doctor', 'nurse'])) {
            return redirect('/login')->with('error', 'Access Restricted. Medical authorization validation clearance required.');
        }

        return $next($request);
    }
}
