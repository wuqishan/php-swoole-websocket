<?php

namespace Event;

class Event
{
    public $message;

    /**
     * 通过链接的 server 对象获取 redis 的存储 key
     *
     * @param $server
     * @param $fd
     * @return string
     */
    public function getRedisKey($server, $fd)
    {
        return implode('_', ['fd', $fd, 'worker_id', $server->worker_id]);
    }



    /**
     * 返回客户端的基本信息
     *
     * @param $server
     * @param $frame
     */
    public function getNormalInfo($server, $frame)
    {
        $this->message['datetime'] = date('Y-m-d H:i:s');
    }

    /**
     * 发送给所有在线用户的信息
     *
     * @param $server
     * @param $message
     * @param null $fd
     * @return bool
     */
    public function pushMsgToAll($server, $message, $fd = null)
    {
        foreach($server->connections as $v) {
            if ($fd !== null && $fd != $v) {
                $server->push($v, json_encode($message));
            } else if ($fd === null) {
                $server->push($v, json_encode($message));
            }
        }

        return true;
    }

    /**
     * 关闭链接发送的消息
     *
     * @param $server
     * @param $message
     * @param $fd
     * @return bool
     */
    public function pushMsgAsClose($server, $message, $fd)
    {
        foreach($server->connections as $v) {
            if ($fd != $v) {
                $server->push($v, json_encode($message));
            }
        }

        return true;
    }

    /**
     * 新建链接发送的消息
     *
     * @param $server
     * @param $message
     * @param $fd
     * @param $users
     * @return bool
     */
    public function pushMsgAsOpen($server, $message, $fd, $users)
    {
        foreach($server->connections as $v) {
            if ($fd == $v) {
                $server->push($v, json_encode(array_merge($message, ['users' => $users])));
            } else {
                $server->push($v, json_encode($message));
            }
        }

        return true;
    }

    /**
     * 自定义写 log
     *
     * @param $msg
     * @param string $filename
     */
    public function L($msg, $filename = '')
    {
        if ($filename === '') {
            $filename = 'mylog.log';
        }
        if (is_array($msg)) {
            @file_put_contents($filename, print_r($msg, true) . "\r\n", FILE_APPEND);
        } else {
            @file_put_contents($filename, $msg . "\r\n", FILE_APPEND);
        }
    }
}





?>