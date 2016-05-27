<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'  => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization'
        ];

        if($request->isMethod('OPTIONS')) {

            $response = new Response();

            foreach($headers as $key => $value) $response->headers->set($key, $value);

            return $response;
        }

        $response = $next($request);

        foreach($headers as $key => $value) $response->headers->set($key, $value);

        return $response;
    }
}
