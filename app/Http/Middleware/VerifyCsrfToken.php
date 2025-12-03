<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // Allow login POSTs from the homepage modal and auth page.
        // Use patterns without a leading slash because Laravel compares
        // against the request "path", e.g. "login" not "/login".
        'login',
        'login/*',
    ];
}
