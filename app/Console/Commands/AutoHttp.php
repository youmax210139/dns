<?php

namespace App\Console\Commands;

use App\Models\Domain;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Console\Command;

class AutoHttp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autohttp:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch domain Http response and store it in database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $promises = [];
        $domains = Domain::all();
        foreach ($domains as $domain) {
            $promises[$domain->id] = $client->getAsync($domain->name);
        }
        $responses = Promise\settle($promises)->wait();
        $responses = collect($responses)->map(function ($value) {
            if ($value['state'] == 'fulfilled') {
                return $value['value'];
            }
            return $value['reason']->getResponse();
        })->map(function ($response) {
            return array_merge($response->getHeaders(), [
                'Status_code' => $response->getStatusCode(),
            ]);
        });
        // store into domain
        foreach ($responses as $id => $response) {
            Domain::where('id', $id)->update([
                'http' => $response,
            ]);
        }
    }
}
