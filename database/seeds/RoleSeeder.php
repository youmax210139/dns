<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{

    protected $ignores = [
        'debugbar',
        'login',
        'logout',
        'locales',
        'images',
    ];

    protected $user_excepts = [
        'users',
        'roles',
        'logs',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $routeCollection = Route::getRoutes();
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);
        foreach ($routeCollection->getRoutes() as $route) {
            $routeName = $this->replace($route->getName());
            if (Str::contains($routeName, $this->ignores) || empty($routeName)) {
                continue;
            }
            $permission = Permission::firstOrCreate(['name' => $routeName]);
            $admin->givePermissionTo($permission);
            if (Str::contains($routeName, $this->user_excepts)) {
                continue;
            }
            $user->givePermissionTo($permission);
        }

    }

    protected function replace($routeName)
    {
        $routeName = str_replace('.update', '.edit', $routeName);
        $routeName = str_replace('.store', '.create', $routeName);
        $routeName = str_replace('.restore', '.destroy', $routeName);
        $routeName = str_replace('.show', '.index', $routeName);
        return $routeName;
    }
}
