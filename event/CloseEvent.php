<?php

namespace Event;

use Event\Event;

class CloseEvent extends Event
{
    public $data;

    public function run($server, $fd)
    {
        // 写入基本数据
        $this->getNormalInfo($server, $fd);
        $this->close($server, $fd);
    }

    public function close($server, $fd)
    {
        $redisKey = $this->getRedisKey($server, $fd);
        $msg = $server->redis->get($redisKey);
        $server->redis->del($redisKey);
        $this->message['from'] = $msg;
        $this->message['type'] = 3;

        $this->pushMsgToAll($server, $this->message, $fd);
    }

}





?>