<?php

use App\Account;
use App\User;
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
    }
}
