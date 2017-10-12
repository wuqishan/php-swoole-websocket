<?php

namespace Event;

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

    public function pushMsgAsClose($server, $message, $fd)
    {
        foreach($server->connections as $v) {
            if ($fd != $v) {
                $server->push($v, json_encode($message));
            }
        }

        return true;
    }

    public function pushMsgAsOpen($server, $message, $fd, $users)
    {
        foreach($server->connections as $v) {
            if ($fd == $v) {
                $server->push($v, json_encode(array_merge($message, ['users' => $users])));
            } else {
                $server->push($v, json_encode($message));
            }
        }

        return true;
    }
}





?>