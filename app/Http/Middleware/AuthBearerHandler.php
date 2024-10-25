<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthBearerHandler
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    $token = $request->bearerToken();

    if (!$token) {
      return response()->json([
        'success' => false,
        'message' => 'Unauthorized',
      ], Response::HTTP_UNAUTHORIZED);
    }

    try {
      // Attempt to validate the token and get the user
      $user = auth()->guard('sanctum')->user();

      if (!$user) {
        return response()->json([
          'success' => false,
          'message' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
      }
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Unauthorized',
      ], Response::HTTP_UNAUTHORIZED);
    }

    return $next($request);
  }

}
