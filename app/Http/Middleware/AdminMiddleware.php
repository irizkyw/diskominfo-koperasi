<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user && $user->role && $user->role->name === 'Administrator') {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}
