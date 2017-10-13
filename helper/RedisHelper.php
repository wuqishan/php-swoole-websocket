<?php

namespace Helper;

class RedisHelper
{
    public $redis;
    public $hash = 'user';

    public function __construct($host, $pass, $port)
    {
        $config = [
            'scheme' => 'tcp',
            'host'   => $host,
            'port'   => $port,
            'password' => $pass
        ];
        $this->redis = new \Predis\Client($config);
    }

    /**
     * redis 保存数据
     *
     * @param $key
     * @param $value
     * @return int
     */
    public function set($key, $value)
    {
        $v = '';
        if (is_array($value)) {
            $v = json_encode($value);
        } if (is_string($value)) {
            $v = $value;
        }

        return $this->redis->hset($this->hash, $key, $v);
    }

    /**
     * 获取 redis 数据
     *
     * @param $key
     * @return string
     */
    public function get($key)
    {
        return $this->redis->hget($this->hash, $key);
    }

    /**
     * 获取 redis 所有的数据
     *
     * @return array
     */
    public function getAll()
    {
        return $this->redis->hgetall($this->hash);
    }

    /**
     * 获取 redis 所有的 value
     *
     * @return array
     */
    public function getAllVal()
    {
        return $this->redis->hvals($this->hash);
    }

    public function getAllKey()
    {
        return $this->redis->hkeys($this->hash);
    }

    /**
     * 判断 redis hash 表中是否存在某值
     *
     * @param $key
     * @return int
     */
    public function exists($key)
    {
        return $this->redis->hexists($this->hash, $key);
    }

    /**
     * 删除 redis 数值
     *
     * @param $key
     * @return int
     */
    public function del($key)
    {
        return $this->redis->hdel($this->hash, $key);
    }

    public function count()
    {
        return count($this->getAllKey());
    }
}














?>