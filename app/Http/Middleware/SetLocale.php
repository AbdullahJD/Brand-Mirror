<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected array $supportedLocales = ['en', 'ar'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale');

        if (! $locale) {
            $locale = $request->getPreferredLanguage(['en', 'ar']) ?? 'en';
        }

        if (! in_array($locale, $this->supportedLocales)) {
            $locale = 'en';
        }

        app()->setLocale($locale);

        session(['locale' => $locale]);

        return $next($request);
    }
}
