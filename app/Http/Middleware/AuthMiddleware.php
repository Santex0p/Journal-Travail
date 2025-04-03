<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;


class AuthMiddleware extends Middleware {
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handle(Request $request, callable $next): Response|\Illuminate\Http\RedirectResponse
    {
        logger('Middleware auth.custom ejecutado');

        if (!Auth::check()) {
            return redirect()->route('login-view');
        }

        return $next($request);
    }



}
