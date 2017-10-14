<?php

namespace Event;

use Event\Event;

class OpenEvent extends Event
{
    public static $allow_conn_number = 500;

    public function run($server, $request)
    {
        // 此处预留待处理
        if ($server->redis->count() >= self::$allow_conn_number) {
            $server->close($request->fd, true);
        }
    }

}





?>