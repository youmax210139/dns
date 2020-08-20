<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Domain;

class WhoisController extends Controller
{
    public function create()
    {
        return Inertia::render('Whois/Create', [
            'domains' => Domain::orderBy('name')
                ->get()
                ->pluck('name'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required',
        ]);
        system("whois $request->url 2>&1", $output);
    }
}
