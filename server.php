<?php

require_once 'event/OpenEvent.class.php';
require_once 'event/MessageEvent.class.php';
require_once 'event/CloseEvent.class.php';
require_once 'helper/RedisHelper.class.php';

session_start();

class WebSocketChat {

    public $server;
    public $open;
    public $message;
    public $close;

    public function __construct()
    {
        $this->open = new OpenEvent();
        $this->message = new MessageEvent();
        $this->close = new CloseEvent();

        $this->server = new swoole_websocket_server('0.0.0.0', 8900);

        $this->server->set(array(
            'daemonize' => false,
            'worker_num' => 1,
        ));
/*
        $this->server->on('Start', function (swoole_websocket_server $server) {
            echo "Server Start... \n";
            swoole_set_process_name("swoole_websocket_server_chat");
        });

        $this->server->on('ManagerStart', function (swoole_websocket_server $server) {
            echo "ManagerStart\n";
        });
*/
        $this->server->on('WorkerStart', function (swoole_websocket_server $server, $worker_id) {
            $redis = new RedisHelper();
            $this->server->redis = $redis->redis;
        });

        $this->server->on('open', function (swoole_websocket_server $server, $request) {
            $this->open->run($server, $request);
        });

        $this->server->on('message', function (swoole_websocket_server $server, $frame) {
            $this->message->run($server, $frame);
        });

        $this->server->on('close', function ($ser, $fd) {
            $this->close->run($ser, $fd);
        });

        $this->server->start();
    }
}

new WebSocketChat();
?>