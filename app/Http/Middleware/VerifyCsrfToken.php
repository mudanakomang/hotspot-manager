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
        'landing/login',
        'landing/alogin',
        'landing/status',
        'landing/logout',
        'landing/login_single',
        'landing/test',
        'voucher/usercheck',
        'voucher/exusercheck',
        'landing/alogin_single',
        'landing/logout_single',
        'landing/status_single',
        'guestinhouse/groupcheck',
        'logs/groupcheck',
        'landing/resetpass',
        'landing/index',
        'landing/login_mice',
        'landing/alogin_mice',
        'landing/logout_mice',
        'landing/status_mice',
        'landing/index_mice'

    ];
}
