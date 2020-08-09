<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DomainController extends Controller
{
    public function index()
    {
        return Inertia::render('Domains/Index', [
            'filters' => Request::all('search', 'trashed'),
            'domains' => Domain::orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'usage_status', 'backup_status', 'expired_at'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Domains/Create');
    }

    public function store(Request $request)
    {
        return Redirect::route('domains.index')
            ->with('success', 'Domain created.');
    }

    public function edit(Domain $organization)
    {
        return Inertia::render('Domains/Edit', [
            'domain' => [
                'id' => $domain->id,
                'name' => $domain->phone,
                'usage_status' => $domain->usage_status,
                'backup_status' => $domain->backup_status,
            ],
        ]);
    }

    public function update(Domain $domain)
    {
        $domain->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'usage_stauts' => ['nullable'],
                'backup_stauts' => ['nullable'],
            ])
        );

        return Redirect::back()
            ->with('success', 'Domain updated.');
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();

        return Redirect::back()
            ->with('success', 'Domain deleted.');
    }
}
