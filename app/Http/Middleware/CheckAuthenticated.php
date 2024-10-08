<?php

namespace App\Http\Middleware;

use App\Repositories\UserTokenRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('indexAction')->with('error', 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}
