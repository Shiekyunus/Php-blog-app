<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    //
    // Switch the application locale based on user selection.
    public function switch(Request $request, string $locale)
    {
        if (!in_array($locale, ['en','ta','hi','my'], true)) {
            abort(404);
        }
        session(['locale' => $locale]);
        return back();
    }
}
