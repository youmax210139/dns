<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Domain;

class TraceController extends Controller
{
    public function create()
    {
        return Inertia::render('Traces/Create', [
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
        system(env('TRACE_PATH') . " $request->url 2>&1", $output);
    }
}
