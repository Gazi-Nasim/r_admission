<?php

namespace App\Http;

use App\Http\Middleware\ApplicationAllowed;
use App\Http\Middleware\AuthenticateStudent;
use App\Http\Middleware\ComplaintSubmissionAllowed;
use App\Http\Middleware\LanguageChangeAllowed;
use App\Http\Middleware\PaymentAllowed;
use App\Http\Middleware\PhotoChangeAllowed;
use App\Http\Middleware\QuotaChangeAllowed;
use App\Http\Middleware\SecurePaymentGateway;
use App\Http\Middleware\SelfieChangeAllowed;
use App\Http\Middleware\VerifyStudentIdentity;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'auth-student'=> AuthenticateStudent::class,
        'verify-identity'=> VerifyStudentIdentity::class,
        'secure-payment' => SecurePaymentGateway::class,
        'application-allowed'=> ApplicationAllowed::class,
        'photo-change-allowed'=> PhotoChangeAllowed::class,
        'selfie-change-allowed'=> SelfieChangeAllowed::class,
        'quota-change-allowed'=> QuotaChangeAllowed::class,
        'language-change-allowed'=> LanguageChangeAllowed::class,
        'complain-allowed'=> ComplaintSubmissionAllowed::class,
        'payment-allowed'=> PaymentAllowed::class,
    ];
}
