<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'login', 'admin/section/sort', 'admin/lesson/sort', 'wishlist/add', 'course/enroll', 'cart/add', 'cart/delete', 'buy/course', 'Invoice', 'message/new/store', 'admin/permissions', 'admin/permissions/store', 'instructor/section/sort', 'instructor/lesson/sort',
    ];
}
