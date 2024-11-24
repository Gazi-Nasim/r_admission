<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PaymentAllowed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (setting('allow_application_payment') == 0) {
            $message = 'Payment is not allowed.';

            if ($request->ajax()) {

                session()->flash('error', $message);

                return response('')
                    ->header("X-IC-Redirect", route('site.home'));
            }

            return redirect()->route('site.home')
                ->with('error', $message);

        }
        return $next($request);
    }
}
