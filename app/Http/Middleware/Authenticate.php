<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // umesto route('login') samo vrati JSON odgovor
            abort(response()->json(['error' => 'Unauthenticated.'], 401));
        }
    }
}
