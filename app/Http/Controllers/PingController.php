<?php

namespace App\Http\Controllers;

use App\ip;
use App\Jobs\PingIpJob;

class PingController extends Controller
{
    public function pingIp($first = 1, $sec = 1, $third = 1, $fourth = 0)
    {
        $stop = 0;
        if ($fourth == 255) {
            $fourth = 0;
            if ($third == 255) {
                $third = 0;
                if ($sec == 255) {
                    $sec = 0;
                    if ($first == 255) {
                        $stop = 1;
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
        $ip = $first . '.' . $sec . '.' . $third . '.' . $fourth;
        if ($stop === 0) {
            try {
                // $ip = '1.1.1.1';
                $ch = curl_init($ip);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $data = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if ($data !== false) {
                    \Log::error('-------------------------Success-----------------------------------------------');
                    \Log::error('IP: ' . $ip);
                    \Log::error('data: ' . json_encode($data));
                    \Log::error('-------------------------------------------------------------------------');
                    $check = ip::where('ip', $ip)->first();
                    if (!$check) {
                        $ip = ip::create([
                            'ip' => $ip,
                        ]);
                    }
                } else {
                    \Log::error('-------------------------Fail-----------------------------------------------');
                    \Log::error('IP: ' . $ip);
                    \Log::error('data: ' . json_encode($data));
                    \Log::error('-------------------------------------------------------------------------');
                }

            } catch (\exception $e) {
                \Log::error('-------------------------Fail-----------------------------------------------');
                \Log::error('IP: ' . $ip);
                \Log::error('data: ' . json_encode($e->getMessage()));
                \Log::error('-------------------------------------------------------------------------');
            }
            PingIpJob::dispatch($first, $sec, $third, $fourth);
        } else {
            \Log::error('All Serries are completed');

        }
    }
}
