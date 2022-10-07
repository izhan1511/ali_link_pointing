<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StopPingJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stop:ping_ip_job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command stops the job for ping the ip address';

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
        \DB::table('jobs')->delete();
    }
}
