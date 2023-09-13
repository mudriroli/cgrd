<?php

namespace App\Service;

class LoggerService
{
    public function log(string $message): void
    {
        $this->createLogFolderIfNotExist();
        $logFile = fopen(__DIR__ . '/../Storage/logs/log.txt', 'a');
        fwrite($logFile, date('Y-m-d H:i:s') . " | " . $message . PHP_EOL);
        fclose($logFile);
    }

    private function createLogFolderIfNotExist(): void
    {
        if (!is_dir(__DIR__ . '/../Storage/logs')) {
            mkdir(__DIR__ . '/../Storage/logs', 0755, true);
        }
    }

}