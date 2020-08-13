<?php

// use App\Models\Platform;
use App\Models\Account;
use App\Models\Domain;
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
        $domains = [
            'www.google.com.tw',
            'yahoo.com.tw',
        ];
        foreach ($domains as $domain) {
            factory(Domain::class)->create([
                'platform_id' => 0,
                'name' => $domain,
            ]);
        }

    }
}
