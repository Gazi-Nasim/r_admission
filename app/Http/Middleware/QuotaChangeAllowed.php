<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Setting;

class QuotaChangeAllowed
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
        if (Setting::get('allow_quota_update') == 0) {
            $message = 'Quota update is not allowed.';

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
