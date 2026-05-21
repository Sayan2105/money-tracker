<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $req, Closure $next, string $role): Response
    {
        if($req->user()->role !== $role){
            return response()->json([
                'message' => 'Unauthorized, not permitted'
            ], 403);
        }

        return $next($req);
    }
}
