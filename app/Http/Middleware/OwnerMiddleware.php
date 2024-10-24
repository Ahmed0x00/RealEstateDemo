<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
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
        $user = Auth::user();

        // Check if the authenticated user has the role "owner"
        if ($user && $user->role === 'owner') {
            return $next($request);
        }

        // If the user is not an owner, return a 403 Forbidden response
        return response()->json(['message' => 'Forbidden'], 403);
    }
}
