<?php

$server = new swoole_server("127.0.0.1", 8901);
$server->set(array(
    'task_worker_num' => 4,
    'task_max_request' => 500
));

$server->on('WorkerStart', function ($server, $worker_id) {

});

$server->on('Receive', function ($server, $fd, $from_id, $data) {

});
$server->on('Task', function ($server, $task_id, $src_worker_id, $data) {

});
$server->on('Finish', function ($server, $task_id, $data) {

});
$server->on('Close', function ($server, $fd, $reactorId) {

});


$server->start();