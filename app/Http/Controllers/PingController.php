<?php

namespace App\Http\Controllers;

use App\ip;
use App\Jobs\PingIpJob;

class PingController extends Controller
{
    public function pingIp()
    {
        $first = rand(0, 255);
        $sec = rand(0, 255);
        $third = rand(0, 255);
        $fourth = rand(0, 255);
        $ip = $first . '.' . $sec . '.' . $third . '.' . $fourth;
        try {
            // $ip = '1.1.1.1';
            $ch = curl_init($ip);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($data !== false) {
                $check = ip::where('ip', $ip)->first();
                if (!$check) {
                    $ip = ip::create([
                        'ip' => $ip,
                    ]);
                }
            } else {
                \Log::error('IP: ' . $ip);
                \Log::error('data: ' . json_encode($data));
            }

        } catch (\exception $e) {
            \Log::error('IP: ' . $ip);
            \Log::error('data: ' . json_encode($e->getMessage()));
        }
        PingIpJob::dispatch();
    }
}
