<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Setting;

class ApplicationAllowed
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
        if (Setting::get('allow_application_submission') == 0) {
            $message = 'Application submission is not allowed.';

            if ($request->ajax()) {
                session()->flash('error', $message);

                return response('')
                    ->header("X-IC-Redirect", route('site.home'));
            } else {
                return redirect()->route('site.home')
                    ->with('error', $message);
            }

        }
        return $next($request);
    }
}
