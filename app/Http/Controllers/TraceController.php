<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TraceController extends Controller
{
    public function create()
    {
        return Inertia::render('Traces/Create');
    }

    public function store(Request $request)
    {
        system(env('TRACE_PATH') . " $request->url 2>&1", $output);
    }
}
