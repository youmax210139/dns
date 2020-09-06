<?php

namespace App\Console\Commands;

use App\Models\Domain;
use Illuminate\Console\Command;
use Whois;
use Log;

class AutoWhois extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autowhois:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run whois cmd and update infomation of domains';

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
        $domains = Domain::all();
        foreach ($domains as $domain) {
            $info = Whois::getInfo($domain->name);
            if (isset($info['expired_at'])) {
                $domain->update([
                    'expired_at' => $info['expired_at'],
                ]);
                $msg = "$domain->name update expired date to {$info['expired_at']}.";
                $this->info($msg);
                Log::info($msg);
            }
        }
    }
}
