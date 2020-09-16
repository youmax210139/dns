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
        foreach ($responses as $id => $value) {
            $response = [];
            // try {
            if ($value['state'] == 'fulfilled') {
                $response = $value['value'];
            } else {
                if (method_exists($value['reason'], 'getResponse')) {
                    $response = $value['reason']->getResponse();
                } else {
                    $response = [
                        'message' => $value['reason']->getMessage(),
                        'Status_code' => $value['reason']->getCode(),
                    ];
                }
            }
            if (!is_array($response)) {
                $response = array_merge(
                    $response->getHeaders(), [
                        'Status_code' => $response->getStatusCode(),
                    ]);
            }
            // store into domain
            Domain::where('id', $id)->update([
                'http' => $response,
            ]);
        }

    }
}
