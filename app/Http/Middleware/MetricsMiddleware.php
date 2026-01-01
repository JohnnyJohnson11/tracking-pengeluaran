<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MetricsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Jangan hitung endpoint /metrics
        if ($request->path() === 'metrics') {
            return $next($request);
        }

        $method = strtoupper($request->method());
        $cacheKey = "metrics_http_requests_{$method}";

        $count = Cache::get($cacheKey, 0);
        $count++;

        Cache::put($cacheKey, $count, now()->addMinutes(5));

        return $next($request);
    }
}
