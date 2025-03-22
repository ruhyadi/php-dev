<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role->slug !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}