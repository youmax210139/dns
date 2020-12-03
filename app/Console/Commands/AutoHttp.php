<?php

namespace App\Console\Commands;

use App\Models\Domain;
use GuzzleHttp\Promise;
use Http;
use Illuminate\Console\Command;
use Log;
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
        $promises = [];
        $domains = Domain::where('enable', true)->get();
        foreach ($domains as $domain) {
            foreach ($domain->protocols as $protocol) {
                $promises[$domain->id . '.' . $protocol] = Http::getAsync($domain->getUrlByProtocol($protocol));
                $this->info("Start Checking {$domain->getUrlByProtocol($protocol)}");
            }
        }
        $responses = Promise\settle($promises)->wait();
        $messages = [];
        foreach ($responses as $key => $value) {
            $value = $value['value']->getContents();
            $key = explode('.', $key);
            $id = $key[0];
            $protocol = $key[1];
            $domain = Domain::find($id);
            if ($domain) {
                $domain->update(['http' => 
                    array_merge($domain->http, [$protocol => $value]),
                ]);
                $url = $domain->getUrlByProtocol($protocol);
                if($value['Status_code'] >= 400)
                {
                    Log::error([
                        'domain' => $url,
                        'response' => $value,
                    ]);
                    $messages[] = ''.
                    "Domain: <a href='{$url}'>{$url}</a>".PHP_EOL.
                    "<b>Status: </b><i>{$value['Status_code']}</i>".PHP_EOL.
                    "<b>Message: </b><em>{$value['Message']}</em>".PHP_EOL.PHP_EOL;
                }
                else
                {
                    Log::info([
                        'domain' => $url,
                        'response' => $value,
                    ]);
                }
            }
        }

        $this->sendMessages($messages);
    }

    protected function sendMessages(array $messages)
    {
        if (!env('TELEGRAM_CHAT_ID', false)) {
            return;
        }
        if (empty($messages)) {
            return;
        }
        $message = '';
        foreach ($messages as $v) {
            $message .= $v;
            if (strlen($message) > 4000) {
                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => $message,
                    'parse_mode' => 'html',
                ]);
                $message = '';
            }
        }
        if(!empty($message))
        {
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => $message,
                'parse_mode' => 'html',
            ]);
        }
    }
}
