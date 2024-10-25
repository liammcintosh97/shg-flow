<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\JsonResponse;

class ThrottleHandler
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, int $maxAttempts = 60, int $minutes = 1): Response
  {
    $key = $request->ip();

    if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
      return new JsonResponse([
        'success' => false,
        'message' => 'Too many requests',
        'data' => null,
      ], 429);
    }

    RateLimiter::hit($key, $minutes * 60);

    return $next($request);
  }
};
