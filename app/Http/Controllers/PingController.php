<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PingController extends Controller
{

    public function create()
    {
        return Inertia::render('Pings/Create', [
            'domains' => Domain::orderBy('name')->get()->only('name'),
        ]);
    }

    public function store()
    {
        // Auth::user()->account->contacts()->create(
        //     Request::validate([
        //         'first_name' => ['required', 'max:50'],
        //         'last_name' => ['required', 'max:50'],
        //         'organization_id' => ['nullable', Rule::exists('organizations', 'id')->where(function ($query) {
        //             $query->where('account_id', Auth::user()->account_id);
        //         })],
        //         'email' => ['nullable', 'max:50', 'email'],
        //         'phone' => ['nullable', 'max:50'],
        //         'address' => ['nullable', 'max:150'],
        //         'city' => ['nullable', 'max:50'],
        //         'region' => ['nullable', 'max:50'],
        //         'country' => ['nullable', 'max:2'],
        //         'postal_code' => ['nullable', 'max:25'],
        //     ])
        // );

        return Redirect::route('pings.create')->with('success', 'Contact created.');
    }

}
