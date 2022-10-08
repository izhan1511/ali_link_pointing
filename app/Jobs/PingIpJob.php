<?php

namespace App\Jobs;

use App\Http\Controllers\PingController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PingIpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $first, $second, $third, $fourth;
    public function __construct($first, $second, $third, $fourth)
    {
        $this->first = $first;
        $this->second = $second;
        $this->third = $third;
        $this->fourth = $fourth;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pingController = new PingController();
        $pingController->pingIp($this->first, $this->second, $this->third, $this->fourth);
    }
}
