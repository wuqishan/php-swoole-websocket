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

    /**
     * 关闭链接执行的方法
     *
     * @param $server
     * @param $fd
     */
    public function close($server, $fd)
    {
        $redisKey = $this->getRedisKey($server, $fd);
        $msg = $server->redis->get($redisKey);
        $server->redis->del($redisKey);
        $this->message['from'] = ['key' => $redisKey, 'value' => $msg];
        $this->message['type'] = 3;

        $this->pushMsgAsClose($server, $this->message, $fd);
    }

}





?>