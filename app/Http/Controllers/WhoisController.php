<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class WhoisController extends Controller
{
    public function create()
    {
        return Inertia::render('Whois/Create');
    }

    public function store(Request $request)
    {
        system("whois $request->url 2>&1", $output);
    }
}
