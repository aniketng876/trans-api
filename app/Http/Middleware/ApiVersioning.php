<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiVersioning
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $version = $request->segment(2); // v1, v2, etc.

        if (!$version || !preg_match('/^v[0-9]+$/', $version)) {
            return response()->json(['error' => 'Invalid API version'], 400);
        }

        // Set version dynamically
        app()->setLocale($version);

        return $next($request);
    }
}
