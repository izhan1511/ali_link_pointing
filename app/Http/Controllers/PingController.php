<?php

namespace App\Http\Controllers;

use App\ip;
use App\Jobs\PingIpJob;

class PingController extends Controller
{
    public function pingIp($first = 1, $sec = 1, $third = 1, $fourth = 0)
    {
        if ($fourth == 255) {
            $fourth = 0;
            if ($third == 255) {
                $third = 0;
                if ($sec == 255) {
                    $sec = 0;
                    if ($first == 255) {
                        $first = 0;
                    } else {
                        $first = $first + 1;
                    }
                } else {
                    $sec = $sec + 1;
                }
            } else {
                $third = $third + 1;
            }
        } else {
            $fourth = $fourth + 1;
        }
        // \Log::error('First: ' . $first);
        // \Log::error('Sec: ' . $sec);
        // \Log::error('third: ' . $third);
        // \Log::error('fourth: ' . $fourth);
        sleep(10);
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
        PingIpJob::dispatch($first, $sec, $third, $fourth);
    }
}
