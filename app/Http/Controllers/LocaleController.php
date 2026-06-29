<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    protected array $supportedLocales = ['en', 'ar'];

    public function switch(string $locale): RedirectResponse
    {
        if (! in_array($locale, $this->supportedLocales, true)) {
            abort(400);
        }

        session(['locale' => $locale]);

        return redirect()->back();
    }
}
