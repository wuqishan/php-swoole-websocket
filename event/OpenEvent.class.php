<?php

require_once 'Event.class.php';

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