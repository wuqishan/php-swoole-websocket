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
            'max_conn' => 1024,            // 最大允许连接数，默认为ulimit -n的值
            'max_request' => 10,      // 表示进程处理完n次请求后结束运行，manager会自动重新创建一个worker进程，防止进程溢出。0表示不重启
            'backlog' => 128,           // 决定同时有多少个待accept的连接，正常情况不会出现大量排队的情况
            'open_cpu_affinity' => 1,   // 启用CPU亲和设置
            'open_tcp_nodelay' => 1,    // 启用tcp_nodelay
            'tcp_defer_accept' => 5,    // 设定一个秒数，当客户端连接连接到服务器时，在约定秒数内并不会触发accept，直到有数据发送，或者超时时才会触发
            'log_file' => 'swoole.log', // 输出的日志文件，默认打印在屏幕上
            'dispatch_mode' => 2,       // 1平均分配，2按FD取模固定分配，3抢占式分配，默认为取模(dispatch=2)
        ));

        $this->server->on('Start', function (swoole_websocket_server $server) {
            echo "Server Start... \n";
        });

        $this->server->on('ManagerStart', function (swoole_websocket_server $server) {
            echo "ManagerStart\n";
        });

        $this->server->on('WorkerStart', function (swoole_websocket_server $server, $worker_id) {
            //swoole_set_process_name("swoole_websocket_server_chat");

//            swoole_timer_tick(2000, function ($timer_id) use ($worker_id) {
////                $server->master_pid;
//                echo "tick-2000ms -- $worker_id\n";
//            });

            $redis = new RedisHelper(getenv('REDIS_SERVER'), getenv('REDIS_PASS'), getenv('REDIS_PORT'));
            $this->server->redis = $redis;
        });

        $this->server->on('open', array($this->open, 'run'));
        $this->server->on('message', array($this->message, 'run'));
        $this->server->on('close', array($this->close, 'run'));


        $this->server->start();
    }
}

new WebSocketChat();
?>