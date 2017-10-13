<?php

class MysqlPool
{
    public static $link = null;

    public function __construct()
    {
        $serv = new swoole_server("127.0.0.1", 8901);
        $serv->set(array(
            'worker_num' => 100,
            'task_worker_num' => 10, //MySQL连接的数量
        ));

        $serv->on('Receive', array($this, 'myOnReceive'));
        $serv->on('Task', array($this, 'myOnTask'));
        $serv->on('Finish', array($this, 'myOnFinish'));

        $serv->start();
    }

    public function myOnReceive($serv, $fd, $from_id, $data)
    {
        //taskwait就是投递一条任务，这里直接传递SQL语句了
        //然后阻塞等待SQL完成
        $result = $serv->taskwait($data);
        if ($result !== false) {
            list($status, $db_res) = explode(':', $result, 2);
            if ($status == 'OK') {
                //数据库操作成功了，执行业务逻辑代码，这里就自动释放掉MySQL连接的占用
                $serv->send($fd, var_export(unserialize($db_res), true) . "\n");
            } else {
                $serv->send($fd, $db_res);
            }
            return;
        } else {
            $serv->send($fd, "Error. Task timeout\n");
        }
    }

    public function myOnTask($serv, $task_id, $from_id, $sql)
    {
        $this->conMysql($serv);

        $result = @self::$link->query($sql);
        if ($result === false) {
            $this->conMysql($serv);
            $result = @self::$link->query($sql);
        }
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $serv->finish("OK:" . serialize($data));
    }

    public function myOnFinish($serv, $data)
    {
        echo "AsyncTask Finish:Connect.PID=" . posix_getpid() . PHP_EOL;
    }

    public function conMysql($serv)
    {
        self::$link = new mysqli("127.0.0.1", "root", "", "test");
        if (! self::$link) {
            $serv->finish("ER:" . mysqli_error(self::$link));
            return;
        }

        return self::$link;
    }
}

new MysqlPool();