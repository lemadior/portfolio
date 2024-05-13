<?php

namespace application\core\traits;

trait SystemMethods
{
    protected function writeLog($msg, $file = 'log.txt', $event = 'ERROR'): void
    {
        $dateTime = new \DateTime();

        $message = $event . ": " . $dateTime->format('d-m-Y G:i:s') . ' ' . $msg . PHP_EOL;

        file_put_contents("application/logs/" .  $file, $message, FILE_APPEND);
    }
}
