<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Domain;
use Illuminate\Support\Facades\Request;

class DomainController extends Controller
{
    public function __invoke()
    {
        // dd(Platform::with('domains')->get());
        return Inertia::render('Platform/Index', [
            'platforms' => Platform::with('domains')->get(),
        ]);
    }

    public function index()
    {
        return Inertia::render('Domain/Index', [
            'filters' => Request::all('search', 'role', 'trashed'),
            'domains' => Domain::orderBy('name')
                // ->filter(Request::only('search', 'role', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'usage_status', 'backup_status', 'expired_at')
        ]);
    }
}
