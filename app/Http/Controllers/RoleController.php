<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
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
            'name' => ['required', 'max:50', 'unique:roles'],
            'permissions' => ['required', 'array'],
            'permissions.*.key' => ['required', 'exists:permissions,id'],
        ]);
        $role = Role::create([
            'name' => Request::get('name'),
        ]);
        $role->syncPermissions(Arr::pluck(Request::get('permissions'), 'key'));
        return Redirect::route('roles.index')->with('success', __('all.create_success', [
            'name' => __('all.role'),
        ]));
    }

    public function edit(Role $role)
    {
        $permissions = [];
        foreach ($role->permissions as $p) {
            $permissions[] = [
                'key' => $p->id,
                'content' => __("all.{$p->name}"),
            ];
        }
        return Inertia::render('Roles/Edit', [
            'role' => [
                'id'   => $role->id,
                'name' => $role->name,
                'permissions' => $permissions,
            ],
            'permissions' => Permission::whereNotIn('id', Arr::pluck($permissions, 'key'))->get()
                ->transform(function ($value) {
                    return [
                        'key' => $value->id,
                        'content' => __("all.{$value->name}"),
                    ];
                }),
        ]);
    }

    public function update(Role $role)
    {
        Request::validate([
            'name' => ['required', 'max:50', Rule::unique('roles')->ignore($role->id)],
            'permissions' => ['required', 'array'],
            'permissions.*.key' => ['required', 'exists:permissions,id'],
        ]);

        $role->update(['name' => Request::get('name')]);
        $role->syncPermissions(Arr::pluck(Request::get('permissions'), 'key'));

        if (Request::wantsJson()) {
            return $role;
        }
        return Redirect::back()->with('success', __('all.edit_success', [
            'name' => __('all.role'),
        ]));
    }

    public function restore(Role $role)
    {
        if ($role->trashed()) {
            $role->restore();
        }

        if (Request::wantsJson()) {
            return response()->json(null);
        }
        return Redirect::back()
            ->with('success', __('all.restore_success', [
                'name' => __('all.role'),
            ]))
            ->withInput();
    }

    public function destroy(Role $role)
    {
        if ($role->trashed()) {
            $role->forceDelete();
        } else {
            $role->delete();
        }

        if (Request::wantsJson()) {
            return response()->json(null);
        }
        return Redirect::back()
            ->with('success', __('all.delete_success', [
                'name' => __('all.role'),
            ]));
    }
}
