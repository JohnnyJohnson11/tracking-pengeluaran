<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

class MetricsController extends Controller
{
    public function metrics()
    {
        $registry = new CollectorRegistry(new InMemory());

        $methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];

        /**
         * 1. Counter per HTTP method
         */
        $methodCounter = $registry->registerCounter(
            'laravel',
            'http_requests_total',
            'Total HTTP requests by method',
            ['method']
        );

        /**
         * 2. Counter total semua HTTP request
         */
        $totalCounter = $registry->registerCounter(
            'laravel',
            'http_requests_all_total',
            'Total HTTP requests (all methods)'
        );

        $totalRequests = 0;

        foreach ($methods as $method) {
            $count = Cache::get("metrics_http_requests_{$method}", 0);

            if ($count > 0) {
                $methodCounter->incBy($count, [$method]);
                $totalRequests += $count;
            }
        }

        // set total keseluruhan
        if ($totalRequests > 0) {
            $totalCounter->incBy($totalRequests);
        }

        $renderer = new RenderTextFormat();

        return response(
            $renderer->render($registry->getMetricFamilySamples()),
            200,
            ['Content-Type' => RenderTextFormat::MIME_TYPE]
        );
    }
}
