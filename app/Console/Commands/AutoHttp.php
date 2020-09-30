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
        $domains = Domain::all();
        foreach ($domains as $domain) {
            $promises[$domain->id] = Http::getAsync($domain->name);
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

        $text = $this->formatMessage($responses);
        if (!empty($text) && env('TELEGRAM_CHAT_ID', false)) {
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHAT_ID'),
                'text' => $text,
                'parse_mode' => 'html',
            ]);
        }
    }

    protected function formatMessage(array $response)
    {
        $message = '';
        foreach ($response as $v) {
            if ($v['Status_code'] < 400) {
                continue;
            }
            $message .= "<b>Domain:</b>{$v['Url']}" . PHP_EOL;
            $message .= "<b>Status:</b><i>{$v['Status_code']}</i>" . PHP_EOL;
            $message .= "<b>Message:</b><em>{$v['Message']}</em>" . PHP_EOL . PHP_EOL;
        }
        return $message;
    }
}
