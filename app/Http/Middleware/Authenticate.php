<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Always return null so Laravel never tries to redirect to a named 'login' route.
     * The exception handler in bootstrap/app.php will return a 401 JSON response instead.
     */
    protected function redirectTo(Request $request): ?string
    {
        return null;
    }
}
