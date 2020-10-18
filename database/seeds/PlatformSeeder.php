<?php

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Platform::count() >= 12) {
            return;
        }
        factory(Platform::class, 12)->create();
    }
}
