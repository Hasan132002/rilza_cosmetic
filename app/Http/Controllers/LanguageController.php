<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'ur'])) {
            abort(400);
        }

        // Store locale in session
        Session::put('locale', $locale);

        // Set app locale
        app()->setLocale($locale);

        return redirect()->back();
    }
}
