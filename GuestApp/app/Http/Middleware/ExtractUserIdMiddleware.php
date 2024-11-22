<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExtractUserIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Extract the user ID from the authenticated user
        $userId = $request->user()->userid;

        // Attach the user ID to the request for further use
        $request->merge(['userid' => $userId]);

        return $next($request);
    }
}