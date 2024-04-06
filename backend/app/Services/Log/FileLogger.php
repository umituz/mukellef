<?php

namespace App\Services\Log;

class FileLogger implements Logger
{
    public function log($message): void
    {
        $filePath = storage_path('logs/app.log');
        $logMessage = '['.date('Y-m-d H:i:s').'] '.$message.PHP_EOL;
        file_put_contents($filePath, $logMessage, FILE_APPEND);
    }
}
