<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response;

class CustomThrottleRequests extends ThrottleRequests
{
    use ApiResponser;
    //redefinimos este metodo
    //ya que crearemos una propia respuesta en vez de usar la predefinida por laravel
    protected function buildResponse($key, $maxAttempts)
    {
        $response = $this->errorResponse('Too Many Attempts.', 429);

        $retryAfter = $this->limiter->availableIn($key);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );
    }
}
