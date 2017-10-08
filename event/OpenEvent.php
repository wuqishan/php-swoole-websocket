<?php

namespace Event;

use Event\Event;

class OpenEvent extends Event
{
    public function __construct()
    {
    }

    public function run($server, $request)
    {
        //print_r($request);

        //$server->redis->set('wuqishan', json_encode($request));

//        foreach ($server->connections as $v) {
//            $server->push($v, "open ....");
//        }
    }

}





?>