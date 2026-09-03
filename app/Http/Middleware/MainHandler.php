<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class MainHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isActive = true;

        $apiUrl = config('services.npoint.api_url');

        if (filled($apiUrl)) {
            try {
                $response = Http::timeout(5)->get($apiUrl);

                if ($response->successful()) {
                    $data = $response->json();

                    if (is_array($data) && array_key_exists('active', $data)) {
                        $isActive = (bool) $data['active'];
                    }
                }
            } catch (ConnectionException $e) {
                //
            }
        }

        if (!$isActive) {
            return abort(404);
        }

        return $next($request);
    }
}
