<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NetcatController extends Controller
{
    public function create()
    {
        return Inertia::render('Netcats/Create');
    }

    public function store(Request $request)
    {
        system("netcat -z -v -w5 $request->url $request->port 2>&1", $output);
    }
}
