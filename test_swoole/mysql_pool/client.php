<?php

$link=new swoole_client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_SYNC);//TCP方式、同步
$link->connect('127.0.0.1',8901);//连接
$link->send('show tables');//执行查询
$res=$link->recv();

if(!$res){
    echo 'Failed!';
}
else{
    echo "<pre>";
    print_r($res);
}
$link->close();