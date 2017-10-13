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
            'daemonize' => false,       // 是否以守护进程方式运行
            'worker_num' => 4,          // worker进程数，异步非阻塞为CPU的1-4倍即可，如果同步阻塞配置为100+，具体看处理请求负载
            'reactor_num' => 2,         // 线程数量，默认设置为CPU核数
            'max_conn' => 10000,        // 最大允许连接数
            'max_request' => 2000,      // 表示进程处理完n次请求后结束运行，manager会自动重新创建一个worker进程，防止进程溢出。0表示不重启
            'backlog' => 128,           // 决定同时有多少个待accept的连接，正常情况不会出现大量排队的情况
            'open_cpu_affinity' => 1,  // 启用CPU亲和设置
            'open_tcp_nodelay' => 1,   // 启用tcp_nodelay
            'tcp_defer_accept' => 5,   // 设定一个秒数，当客户端连接连接到服务器时，在约定秒数内并不会触发accept，直到有数据发送，或者超时时才会触发
            'log_file' => 'swoole.log',// 输出的日志文件，默认打印在屏幕上
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