<?php

namespace App\Http\Controllers;

use App\Platform;
use Inertia\Inertia;

class PlatformController extends Controller
{
    public function __invoke()
    {
        // dd(Platform::with('domains')->get());
        return Inertia::render('Platform/Index', [
            'platforms' => Platform::with('domains')->get(),
        ]);
    }
}
