<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PlatformSeeder::class,
            DomainSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
