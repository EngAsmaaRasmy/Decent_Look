<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AdminAPIAuthenticate
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
        $client = new Client(['verify' => false]);
        $quzzle_request = $client->post(env('MS_URL') . 'authorization', $params = [
            'headers' => [
                'Authorization' => $request->header('Authorization'),
            ]
        ]);
        $response = json_decode($quzzle_request->getBody());
        if ($response->error) {
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }
}
