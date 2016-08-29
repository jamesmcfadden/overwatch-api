<?php

namespace App\Http\Middleware;

use Closure;

class Analytics
{
    const BASE_URL = 'http://www.google-analytics.com/collect';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (! config('app.analytics.server_ua')) {
            return $next($request);
        }
        $params = [
            'v' => 1,
            'tid' => config('app.analytics.server_ua'),
            'cid' => 1,
            't' => 'pageview',
            'dp' => $request->getRequestUri(),
        ];
        $url = self::BASE_URL.'?'.http_build_query($params);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        return $next($request);
    }
}
