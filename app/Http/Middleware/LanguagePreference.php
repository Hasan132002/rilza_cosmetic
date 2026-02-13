<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LanguagePreference
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get language from session or cookie, default to config
        $locale = Session::get('locale', $request->cookie('locale', config('app.locale')));

        // Validate locale
        $availableLocales = ['en', 'ur']; // English and Urdu
        if (in_array($locale, $availableLocales)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
