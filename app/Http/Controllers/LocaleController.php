<?php

namespace App\Http\Controllers;

use URL;

class LocaleController extends Controller
{
    public function index($locale)
    {
        return redirect()->to(\LaravelLocalization::getLocalizedURL($locale, URL::previous()))
            ->withCookie(cookie('locale', $locale,  24*60));
    }
}
