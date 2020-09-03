<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Redirect;

class DomainController extends Controller
{
    public function index()
    {
        return Inertia::render('Domains/Index', [
            'filters' => Request::all('search', 'trashed'),
            'domains' => Domain::orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'hostname', 'name', 'usage', 'backup', 'expired_at'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Domains/Create');
    }

    public function store()
    {
        Domain::create(
            Request::validate([
                'name' => ['required', 'unique:domains', 'max:100'],
                'backup' => ['required', 'boolean'],
                'renew' => ['required', 'boolean'],
            ])
        );
        return Redirect::route('domains.index')
            ->with('success', 'Domain created.');
    }

    public function edit(Domain $domain)
    {
        return Inertia::render('Domains/Edit', [
            'domain' => [
                'id' => $domain->id,
                'name' => $domain->name,
                'backup' => $domain->backup,
                'renew' => $domain->renew,
            ],
        ]);
    }

    public function update(Domain $domain)
    {
        $domain->update(
            Request::validate([
                'name' => ['required', "unique:domains,name,{$domain->id}", 'max:100'],
                'backup' => ['required', 'boolean'],
                'renew' => ['required', 'boolean'],
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
