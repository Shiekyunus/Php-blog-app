<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    // Set the application locale based on the user's session or default to English.
    public function handle(Request $request, Closure $next): Response
    {
        App::setLocale(session('locale', 'en'));
        return $next($request);
    }
}
