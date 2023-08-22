<?php

namespace App\Http\Middleware;

use App\Responses\JsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorizeApiKey
{
    private $apiKey;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the Api Key from the request
        $this->apiKey = request()->header('API-KEY');

        if ($this->apiKey === null) {
            // If the request wants JSON (AJAX doesn't always want JSON)
            if ($request->wantsJson()) {
                return response()->json(new JsonResponse([], 'Unauthorized'), Response::HTTP_UNAUTHORIZED);
            }
        }

        if (!$this->isValidApiKey($this->apiKey)) {
            // If the request wants JSON (AJAX doesn't always want JSON)
            if ($request->wantsJson()) {
                return response()->json(new JsonResponse([], 'Unauthorized'), Response::HTTP_UNAUTHORIZED);
            }
        }

        if (!request()->expectsJson()) {
            return response()->json(new JsonResponse([], 'Unauthorized'), Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    /**
     * Validate the api key to the env api key
     *
     * @param String $apiKey
     * @return boolean
     */
    private function isValidApiKey($apiKey)
    {
        if ($apiKey !== config('app.api_key')) {
            return false;
        }
        return true;
    }
}
