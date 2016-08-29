<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests as BaseThrottleRequests;
use Illuminate\Http\JsonResponse;

class ThrottleRequests extends BaseThrottleRequests
{
    /**
     * Override Illuminate\Routing\Middleware\ThrottleRequests to provide
     * a valid JSON response.
     */
    protected function buildResponse($key, $maxAttempts)
    {
        $response = new JsonResponse([
            'error' => 'Too Many Attempts.',
        ], 429);

        $retryAfter = $this->limiter->availableIn($key);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );
    }
}
