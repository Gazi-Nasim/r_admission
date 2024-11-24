<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Setting;

class ComplaintSubmissionAllowed
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
        if (Setting::get('allow_complaint_submission') == 0) {
            abort(404);
        }

        return $next($request);
    }
}
