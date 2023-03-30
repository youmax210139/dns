<?php

namespace App\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use App\Repositories\LogRepository;

class MySQLLoggingHandler extends AbstractProcessingHandler
{

    protected function write(array $record): void
    {
        $data = array(
            'message' => $record['message'],
            'context' => json_encode($record['context']),
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'channel' => $record['channel'],
            'datetime' => $record['datetime']->format('Y-m-d H:i:s'),
            'extra' => json_encode($record['extra']),
            'created_at' => date("Y-m-d H:i:s"),
        );
        LogRepository::insert($data);
    }
}
