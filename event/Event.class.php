<?php

class Event
{
    public function pushMsgToAll($server, $message)
    {
        foreach($server->connections as $v) {
            $server->push($v, json_encode($message));
        }

        return true;
    }


}





?>