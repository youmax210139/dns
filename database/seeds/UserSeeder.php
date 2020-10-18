<?php

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->raw([
            'first_name' => 'Charlie',
            'last_name' => 'Yuan',
            'email' => 'admin@gmail.com',
        ]);
        $user = User::firstOrCreate(Arr::only($user, ['email']), $user);
        $role = Role::where('name', 'admin')->first();
        if($role){
            $user->assignRole($role);
        }
    }
}
