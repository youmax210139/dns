<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Domain;
use Whois;

class WhoisController extends Controller
{
    public function create()
    {
        return Inertia::render('Whois/Create', [
            'domains' => Domain::orderBy('name')
                ->get()
                ->pluck('name')
                ->unique()->values(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required',
        ]);
        return Whois::getInfo($request->url);
    }
}
