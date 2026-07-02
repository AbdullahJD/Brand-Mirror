<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // admin أو أي صفحة داخل admin
        if ($request->is('management-hub-v4r9') || $request->is('management-hub-v4r9/*')) {
            return route('/management-hub-v4r9.login');
        }

        return route('store.login');
    }
}
