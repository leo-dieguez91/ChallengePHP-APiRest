<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ActionLog;
use Illuminate\Http\Request;

class LogActions
{
    private $sensitiveFields = [
        'password',
        'password_confirmation',
        'current_password',
        'new_password',
    ];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        ActionLog::create([
            'user_id' => auth()->id(),
            'service' => $request->path(),
            'request_body' => $this->filterSensitiveData($request->all()),
            'response_code' => $response->status(),
            'response_body' => $this->getResponseBody($response),
            'ip_address' => $request->ip()
        ]);

        return $response;
    }

    private function filterSensitiveData(array $data): array
    {
        foreach ($this->sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '********';
            }
        }
        return $data;
    }

    private function getResponseBody($response)
    {
        $content = $response->getContent();
        return json_decode($content, true) ?? $content;
    }
} 