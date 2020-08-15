<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class WhoisController extends Controller
{
    public function create()
    {
        return Inertia::render('Whois/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required',
        ]);
        system("whois $request->url 2>&1", $output);
    }
}
