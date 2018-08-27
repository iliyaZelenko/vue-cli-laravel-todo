<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth()->check()) { // auth()->check()
            logger(auth()->user()->name);
            if ($guard === 'api') {
                return response()->json([
                    'message' => 'This route only for guests.'
                ], 403);
            }
            return redirect('/home');
        }

        return $next($request);
    }
}
