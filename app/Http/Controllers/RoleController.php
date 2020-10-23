<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        $fields = [
            'id' => 'id',
            'name' => 'role',
            'permission' => 'permission',
            'deleted_at' => 'deleted_at',
            'actions' => 'operation',
        ];
        if (Request::wantsJson()) {
            return Role::query()
                ->sort(Request::get('sort'))
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only(...array_keys($fields));
        }

        return Inertia::render('Roles/Index', [
            'filters' => Request::all('search', 'trashed'),
            'fields' => $this->getDataTableFields($fields, ['actions'], ['deleted_at']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Roles/Create', [
            'permissions' => Permission::all()->transform(function ($value) {
                return [
                    'key' => $value->id,
                    'content' => __("all.{$value->name}"),
                ];
            }),
        ]);
    }

    public function store()
    {
        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
            'password' => ['required', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        User::create([
            'first_name' => Request::get('first_name'),
            'last_name' => Request::get('last_name'),
            'email' => Request::get('email'),
            'password' => Request::get('password'),
            'photo_path' => Request::file('photo') ? Request::file('photo')->store('users') : null,
        ]);

        return Redirect::route('users.index')->with('success', __('all.users.create_success'));
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user->only('id', 'first_name', 'last_name', 'email', 'role_id'),
            'roles' => Role::all()->transform(function ($role) {
                return [
                    'label' => $role->name,
                    'code' => $role->id,
                ];
            }),
        ]);
    }

    public function update(User $user)
    {
        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')->ignore($user->id)],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'confirmed'],
            'photo' => ['nullable', 'image'],
        ]);

        $user->update(Request::only('first_name', 'last_name', 'email'));
        $user->assignRole(Request::get('role_id'));

        if (Request::file('photo')) {
            $user->update(['photo_path' => Request::file('photo')->store('users')]);
        }

        if (Request::get('password')) {
            $user->update(['password' => Request::get('password')]);
        }

        if (Request::wantsJson()) {
            return $user;
        }
        return Redirect::back()->with('success', __('all.users.edit_success'));
    }

    public function restore(User $user)
    {
        if ($user->trashed()) {
            $user->restore();
        }

        if (Request::wantsJson()) {
            return response()->json(null);
        }
        return Redirect::back()
            ->with('success', __('all.restore_user_success'))
            ->withInput();
    }

    public function destroy(User $user)
    {
        if ($user->trashed()) {
            $user->forceDelete();
        } else {
            $user->delete();
        }

        if (Request::wantsJson()) {
            return response()->json(null);
        }
        return Redirect::back()
            ->with('success', __('all.delete_user_success'));
    }
}
