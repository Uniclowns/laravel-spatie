<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccessMiddleware
{
    public function handle(Request $request, Closure $next, $userType) : Response
    {
        if(auth()->user()->type === $userType) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
