<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorHelper
{
    public static function handelError(\Throwable $th, $log_message, $error_message)
    {
        $logger = GeneralHelper::getLogger();
        $logger->info($log_message);
        $logger->info($th);
        if ($th instanceof HttpExceptionInterface) {
            if ($th->getStatusCode() == 404) {
                $error_message = 'notFound';
            }
        } else if ($th instanceof ModelNotFoundException) {
            $error_message = 'notFound';
        }
        return redirect()->back()->withErrors([
            'text' => $error_message,
            'type' => 'error',
            'root' => 'system',
        ]);
    }

    public static function handelErrorWithoutLog($error_message)
    {
        return response()->json([
            'text' => $error_message,
            'type' => 'error',
            'root' => 'system',
        ], 400);
    }

    public static function handelErrorWithoutResponse($th, $log_message)
    {
        $logger = GeneralHelper::getLogger();
        $logger->info($log_message);
        $logger->info($th);
    }
}
