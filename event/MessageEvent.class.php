<?php

require_once 'Event.class.php';

class MessageEvent extends Event
{
    public $data;
    public $message;

    public function getNormalInfo($server, $frame)
    {
        $this->message['datetime'] = date('Y-m-d H:i:s');
    }

    public function run($server, $frame)
    {
        $this->getNormalInfo($server, $frame);
        $this->data = json_decode($frame->data);
        switch (intval($this->data->type)) {
            case 1:
                $this->chatMessage($server, $frame);
                break;
            case 2:
                $this->entryUser($server, $frame);
                break;

            default:

                break;
        }
    }

    public function chatMessage($server, $frame)
    {
        $redisKey = implode('_', [$frame->fd, $server->worker_id]);
        $this->message['from'] = $server->redis->get($redisKey);
        $this->message['type'] = 1;

        $this->pushMsgToAll($server, $this->message);
    }

    public function entryUser($server, $frame)
    {
        $redisKey = implode('_', [$frame->fd, $server->worker_id]);
        $server->redis->set($redisKey, $this->data->msg);
        $this->message['from'] = $this->data->msg;
        $this->message['type'] = 2;

        $this->pushMsgToAll($server, $this->message);
    }
}





?>