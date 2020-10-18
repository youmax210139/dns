<?php

use App\Models\Domain;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domains = [
            'www.google.com.tw',
            'yahoo.com.tw',
            'newbs-b1111s.dl868.com',
            'cfapi.xin6.org',
            'www.google.com.jp',
        ];
        foreach ($domains as $domain) {
            $data = factory(Domain::class)->raw([
                'name' => $domain,
            ]);
            Domain::firstOrCreate(Arr::only($data, ['name']), $data);
        }
    }
}
