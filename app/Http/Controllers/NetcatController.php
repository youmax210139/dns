<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Domain;

class NetcatController extends Controller
{
    public function create()
    {
        return Inertia::render('Netcats/Create', [
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
            'port' => 'required|numeric'
        ]);
        system("netcat -z -v -w5 $request->url $request->port 2>&1", $output);
    }
}
