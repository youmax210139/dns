<?php

namespace App\Console\Commands;

use App\Models\Domain;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Http;
use Illuminate\Console\Command;
use Telegram;

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
        $domains = Domain::where('enable', true)->get();
        foreach ($domains as $domain) {
            $promises[$domain->id] = Http::getAsync($domain->name);
            $this->info($domain->name);
        }
        $responses = Promise\settle($promises)->wait();
        foreach ($responses as $id => $value) {
            $value = $value['value']->getContents();
            $domain = Domain::find($id);
            if ($domain) {
                $domain->update(['http' => $value]);
                $value['Url'] = $domain->name;
            }
            $responses[$id] = $value;
        }

        $this->convert($responses);
    }

    protected function convert(array $response)
    {
        $message = '';
        foreach ($response as $v) {
            if ($v['Status_code'] < 400) {
                continue;
            }
            $message .= "Domain: <a href='http://{$v['Url']}'>{$v['Url']}</a>" . PHP_EOL;
            $message .= "<b>Status: </b><i>{$v['Status_code']}</i>" . PHP_EOL;
            $message .= "<b>Message: </b><em>{$v['Message']}</em>" . PHP_EOL . PHP_EOL;

            if(strlen($message) >  4000){
                $this->sendMessage($message);
                $message = '';
            }
        }

        $this->sendMessage($message);
    }

    protected function sendMessage($message)
    {
        if(!env('TELEGRAM_CHAT_ID', false)){
            return;
        }
        if(empty($message)) return;
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => $message,
            'parse_mode' => 'html',
        ]);
    }
}
