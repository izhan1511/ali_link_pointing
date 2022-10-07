<?php

namespace App\Console\Commands;

use App\Jobs\PingIpJob;
use Illuminate\Console\Command;

class StartPingJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:ping_ip_job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command starts a new job for ping the ip address';

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
        PingIpJob::dispatch();
    }
}
