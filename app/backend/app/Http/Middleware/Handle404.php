<?php

namespace App\Http\Middleware;

use Closure;

class Handle404
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response->status() === 404) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        return $response;
    }
}
