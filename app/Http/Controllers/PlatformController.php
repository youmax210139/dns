<?php

namespace App\Http\Controllers;

use App\Exports\PlatformExport;
use App\Models\Platform;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Redirect;

class PlatformController extends Controller
{
    public function index()
    {
        $fields = [
            'id' => 'id',
            'name' => 'platform',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' => 'deleted_at',
            'actions' => 'operation',
        ];
        if (Request::wantsJson()) {
            return Platform::query()
                ->sort(Request::get('sort'))
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only(...array_keys($fields));
        }
        return Inertia::render('Platforms/Index', [
            'filters' => Request::all('search', 'trashed'),
            'fields' => $this->getDataTableFields($fields, ['actions'], ['deleted_at']),
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
            ->with('success', __('all.create_platform_success'));
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
            ->with('success', __('all.edit_platform_success'));
    }

    public function restore(Platform $platform)
    {
        if ($platform->trashed()) {
            $platform->restore();
        }

        if (Request::wantsJson()) {
            return response()->json(null);
        }
        return Redirect::back()
            ->with('success', __('all.restore_platform_success'))
            ->withInput();
    }

    public function destroy(Platform $platform)
    {
        if ($platform->trashed()) {
            $platform->forceDelete();
        } else {
            $platform->delete();
        }

        if (Request::wantsJson()) {
            return response()->json(null);
        }
        return Redirect::back()
            ->with('success', __('all.delete_platform_success'));
    }

    public function export()
    {
        return new PlatformExport();
    }
}
