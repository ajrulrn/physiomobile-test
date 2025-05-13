<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accessKey = $request->header('accessKey');

        if (!$accessKey) {
            return response()->json([
                'success' => false,
                'message' => 'API key is missing'
            ], 401);
        }

        if ($accessKey !== env('ACCESS_KEY')) {
            return response()->json([
                'success' => false,
                'message' => 'invalid API Key'
            ], 401);
        }

        return $next($request);
    }
}
