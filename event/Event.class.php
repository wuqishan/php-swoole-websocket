<?php

class Event
{
    public $message;

    public function getRedisKey($server, $fd)
    {
        return implode('_', [$fd, $server->worker_id]);
    }

    public function getNormalInfo($server, $frame)
    {
        $this->message['datetime'] = date('Y-m-d H:i:s');
    }

    public function pushMsgToAll($server, $message, $fd = null)
    {
        foreach($server->connections as $v) {
            if ($fd !== null && $fd != $v) {
                $server->push($v, json_encode($message));
            } else if ($fd === null) {
                $server->push($v, json_encode($message));
            }
        }

        return true;
    }


}





?>