<?php

namespace App\Helpers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Illuminate\Support\Str;

class GeneralHelper
{
    public static function convertDate($value)
    {
        if (is_null($value)) {
            return $value;
        }
        if (is_string($value)) {
            $value = Carbon::parse($value);
        }
        return $value->format('Y-m-d');
    }

    public static function convertTime($value)
    {
        if (is_null($value)) {
            return $value;
        }
        return $value->format('H:i');
    }

    public static function getLogger()
    {
        $dateString = now()->format('d_m_Y');
        $filePath = 'errors_' . $dateString . '.log';
        $dateFormat = "m/d/Y H:i:s";
        $output = "[%datetime%] %channel%.%level_name%: %message%\n";
        $formatter = new LineFormatter($output, $dateFormat);
        $stream = new StreamHandler(storage_path('logs/' . $filePath), Logger::DEBUG);
        $stream->setFormatter($formatter);
        $processId = Str::random(5);
        $logger = new Logger($processId);
        $logger->pushHandler($stream);

        return $logger;
    }

    public static function convertDateTime($date)
    {
        if (is_null($date)) {
            return $date;
        }
        return Carbon::createFromTimestamp(strtotime($date))
            ->timezone(Config::get('app.timezone'))
            ->toDateTimeString();
    }
}
