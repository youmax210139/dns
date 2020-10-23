<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PlatformSeeder::class,
            DomainSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
