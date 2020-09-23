<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Platform;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Redirect;
use Whois;

class DomainController extends Controller
{
    public function index()
    {
        $fields = [
            'id' => 'id',
            'hostname' => 'main_domain',
            'name' => 'domain',
            'usage' => 'usage',
            'backup' => 'backup',
            'expired_at' => 'expired_at',
            'platform_name' => 'platform',
            'http_status_code' => 'http_status_code',
            'actions' => 'operation',
        ];

        if (Request::wantsJson()) {
            return Domain::leftjoin('platforms', 'domains.platform_id', '=', 'platforms.id')
                ->select('domains.*', 'platforms.name as platform_name', 'domains.http->Status_code as http_status_code')
                ->sort(Request::get('sort'))
                ->filter(Request::only('search', 'trashed'))
                ->paginate(2)
                ->only(...array_keys($fields));
        }
        return Inertia::render('Domains/Index', [
            'filters' => Request::all('search', 'trashed'),
            'fields' => $this->getDataTableFields($fields, ['actions', 'hostname']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Domains/Create', [
            'platforms' => Platform::all()->transform(function ($platform) {
                return [
                    'label' => $platform->name,
                    'code' => $platform->id,
                ];
            }),
        ]);
    }

    public function store()
    {
        Domain::create(
            array_merge(
                Request::validate([
                    'name' => ['required', 'unique:domains', 'max:100'],
                    'backup' => ['required', 'boolean'],
                    'renew' => ['required', 'boolean'],
                    'platform_id' => ['required', 'numeric'],
                ]),
                [
                    'expired_at' => Whois::getInfo(request()->name)['expired_at'] ?? null,
                ]
            )
        );
        return Redirect::route('domains.index')
            ->with('success', __('all.create_domain_success'));
    }

    public function edit(Domain $domain)
    {
        return Inertia::render('Domains/Edit', [
            'domain' => $domain->only('id', 'name', 'backup', 'renew', 'platform_id'),
            'platforms' => Platform::all()->transform(function ($platform) {
                return [
                    'label' => $platform->name,
                    'code' => $platform->id,
                ];
            }),
        ]);
    }
    public function update(Domain $domain)
    {
        if (Request::get('platform_id') == null) {
            Request::merge([
                'platform_id' => 0,
            ]);
        } else {
            Request::validate([
                'platform_id' => 'exists:platforms,id',
            ]);
        }
        $domain->update(
            Request::validate([
                'name' => ['required', "unique:domains,name,{$domain->id}", 'max:100'],
                'backup' => ['required', 'boolean'],
                'renew' => ['required', 'boolean'],
                'platform_id' => ['required', 'numeric'],
            ])
        );

        return Redirect::back()
            ->with('success', __('all.edit_domain_success'));
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();

        return Redirect::back()
            ->with('success', __('all.delete_domain_success'));
    }
}
