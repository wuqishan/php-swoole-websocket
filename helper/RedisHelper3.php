<?php

namespace Helper;

class RedisHelper3
{
    public $redis;
    public $hash = 'user';

    public function __construct($host, $port)
    {
        $this->redis = new \Redis();
        $this->redis->connect($host, $port);
    }

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

    public function get($key)
    {
        return $this->redis->hget($this->hash, $key);
    }

    public function getAll()
    {
        return $this->redis->hgetall($this->hash);
    }

    public function getAllVal()
    {
        return $this->redis->hvals($this->hash);
    }

    public function getAllKey()
    {
        return $this->redis->hkeys($this->hash);
    }

    public function exists($key)
    {
        return $this->redis->hexists($this->hash, $key);
    }

    public function del($key)
    {
        return $this->redis->hdel($this->hash, $key);
    }

}














?>