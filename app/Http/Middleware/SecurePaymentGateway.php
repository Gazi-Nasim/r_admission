<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SecurePaymentGateway
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(config('app.debug')) {
            return $next($request);
        }

        $allowed_ip = ['172.19.0.2','103.79.117.91', '103.79.117.119', '::1', '127.0.0.1', '27.147.186.237'];

        $client = $request->server('REMOTE_ADDR');
//        dd($request->server());

        if ( !in_array($client, $allowed_ip) ) {
            abort(403, 'Unauthorized action.');
        }


        return $next($request);
    }
}
