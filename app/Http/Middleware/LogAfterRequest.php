<?php

namespace App\Http\Middleware;

use App\Models\Request;
use Illuminate\Support\Facades\Log;

class LogAfterRequest
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
    public function terminate($request, $response)
    {
        $url = $request->fullUrl();
        $ip = $request->ip();
        $r = new Request();
        $r->ip = $ip;
        $r->url = $url;
        $r->method = $request->method();
        $r->request = json_encode([
            'headers' => $request->header(),
            'body' => $request->except(['password']),
        ]);
        $r->response = $response->status();
        $r->save();

        $format_response = [
            'status' => $response->status() < 300 ? 'Success' : 'Failed',
            'method' => $request->method(),
            'url' => $url,
        ];
        $context = [
            'X-RANDOM' => $request->header('X-RANDOM'),
            'counter' => $request->counter,
        ];
        Log::setTimezone(new \DateTimeZone('GMT+7'));
        Log::info($format_response['status'] .': '. $format_response['method'] . ' '. $format_response['url'], $context);
    }
}
