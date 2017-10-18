<?php

$client = new swoole_client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_ASYNC);//TCP方式、异步
$client->connect('127.0.0.1',8901);//连接
$client->send('show tables');//执行查询
$res=$link->recv();

if(!$res){
    echo 'Failed!';
}
else{
    echo "<pre>";
    print_r($res);
}
$link->close();