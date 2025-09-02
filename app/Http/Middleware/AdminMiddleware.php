<?php

namespace App\Http\Middleware;

use AppCore;
use Auth;
use Closure;
use Exception;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            throw new Exception('admin required.', 1);
        }

        if (Auth::user()->isAdmin()) {
            return $next($request);
        } else {
            throw new Exception('admin required.', 1);
        }
    }
}
