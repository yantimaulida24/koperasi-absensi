<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsKaryawan;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\Authenticate;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     */
    protected $routeMiddleware = [
        // middleware bawaan Laravel
        'auth' => Authenticate::class,
        'verified' => EnsureEmailIsVerified::class,

        // middleware custom
        'isAdmin' => IsAdmin::class,
        'isKaryawan' => IsKaryawan::class,
    ];
}
