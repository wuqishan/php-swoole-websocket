<?php

require_once '../vendor/autoload.php';

use Dotenv\Dotenv;
use Event\OpenEvent;
use Event\CloseEvent;
use Event\MessageEvent;
use Helper\RedisHelper;

class WebSocketChat
{
    public $server;
    public $open;
    public $message;
    public $close;

    public function __construct()
    {
        $env = new Dotenv('../');
        $env->load();

        $this->open = new OpenEvent();
        $this->message = new MessageEvent();
        $this->close = new CloseEvent();

        $this->server = new swoole_websocket_server(getenv('WEBSOCKET_SERVER'), getenv('WEBSOCKER_PORT'));

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
            $redis = new RedisHelper(getenv('REDIS_SERVER'), getenv('REDIS_PASS'), getenv('REDIS_PORT'));
            $this->server->redis = $redis;
        });

        $this->server->on('open', function (swoole_websocket_server $server, $request) {
            $this->open->run($server, $request);
        });

        $this->server->on('message', function (swoole_websocket_server $server, $frame) {
            $this->message->run($server, $frame);
        });

        $this->server->on('close', function ($server, $fd) {
            $this->close->run($server, $fd);
        });

        $this->server->start();
    }
}

new WebSocketChat();
?>