<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerifyStudentIdentity
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

        $student = $request->session()->get('student', null);

        if ( !$student ) {
            return redirect()->route('site.home');
        }

        if ( $student->mobile_no_verified || $student->email_verified ) {
            return $next($request);
        }

        if ( $request->ajax() ) {
            return response('')
                ->header("X-IC-Redirect", route('identity_verification.index'));
        } else {
            return redirect()->route('identity_verification.index');
        }


    }
}
