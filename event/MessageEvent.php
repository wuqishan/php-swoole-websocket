<?php

namespace Event;

use Event\Event;

class MessageEvent extends Event
{
    public $data;

    public function run($server, $frame)
    {
        // 写入基本数据
        $this->getNormalInfo($server, $frame);
        $this->data = json_decode($frame->data);
        switch (intval($this->data->type)) {
            case 1:
                $this->chat($server, $frame);
                break;
            case 2:
                $this->open($server, $frame);
                break;
            default:

                break;
        }
    }

    public function chat($server, $frame)
    {
        $redisKey = $this->getRedisKey($server, $frame->fd);
        $this->message['from'] = ['key' => $redisKey, 'value' => $server->redis->get($redisKey)];
        $this->message['type'] = 1;
        $this->message['message'] = $this->data->msg;

        $this->pushMsgToAll($server, $this->message);
    }

    public function open($server, $frame)
    {
        $redisKey = $this->getRedisKey($server, $frame->fd);
        $server->redis->set($redisKey, $this->data->msg);
        $users = $server->redis->getAll();
        $this->message['from'] = ['key' => $redisKey, 'value' => $this->data->msg];
        $this->message['type'] = 2;

        $this->pushMsgAsOpen($server, $this->message, $frame->fd, $users);
    }
}





?>