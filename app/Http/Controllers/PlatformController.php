<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Redirect;

class PlatformController extends Controller
{
    public function index()
    {
        return Inertia::render('Platforms/Index', [
            'filters' => Request::all('search', 'trashed'),
            'platforms' => Platform::orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'created_at', 'updated_at'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Platforms/Create');
    }

    public function store()
    {
        Platform::create(
            Request::validate([
                'name' => ['required', 'unique:platforms', 'max:100'],
            ])
        );
        return Redirect::route('platforms.index')
            ->with('success', 'Platform created.');
    }

    public function edit(Platform $platform)
    {
        return Inertia::render('Platforms/Edit', [
            'platform' => [
                'id' => $platform->id,
                'name' => $platform->name,
                'created_at' => $platform->created_at,
                'updated_at' => $platform->updated_at,
            ],
        ]);
    }

    public function update(Platform $platform)
    {
        $platform->update(
            Request::validate([
                'name' => ['required', "unique:platforms,name,{$platform->id}", 'max:100'],
            ])
        );

        return Redirect::back()
            ->with('success', 'Platform updated.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();

        return Redirect::back()
            ->with('success', 'Platform deleted.');
    }
}
