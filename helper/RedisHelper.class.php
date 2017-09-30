<?php

class RedisHelper
{
    public $redis;
    public $hash = 'userTable';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function set($key, $value)
    {
        $v = '';
        if (is_array($value)) {
            $v = json_encode($value);
        } if (is_string($value)) {
            $v = $value;
        }

        return $this->redis->hSet($this->hash, $key, $v);
    }

    public function get($key)
    {
        return $this->redis->hGet($this->hash, $key);
    }

    public function exists($key)
    {
        return $this->redis->hExists($this->hash, $key);
    }

    public function del($key)
    {
        return $this->redis->hDel($this->hash, $key);
    }

}














?>