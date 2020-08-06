<?php

// use App\Models\Platform;
use App\Models\Domain;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        $account = Account::create(['name' => 'IT Corporation']);

        factory(User::class)->create([
            'account_id' => $account->id,
            'first_name' => 'Charlie',
            'last_name' => 'Yuan',
            'email' => 'admin@gmail.com',
            'owner' => true,
        ]);

        // $platform = Platform::create(['name'=>'google.com.tw']);
        factory(Domain::class, 20)->create([
            'platform_id' => 0,
        ]);
    }
}
