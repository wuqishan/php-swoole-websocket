<?php

require_once 'Event.class.php';

class CloseEvent extends Event
{
    public function __construct()
    {
    }

    public function run($server, $fd)
    {
        print_r($server);
        foreach ($server->connections as $v) {
            //$server->push($v, $request->get['message']);
            //echo $v."\n";
        }

        echo "client {$fd} closed\n";
    }

}





?>