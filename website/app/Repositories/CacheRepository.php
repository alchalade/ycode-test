<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;

class CacheRepository implements ICacheRepository
{
    public function __construct()
    {
    }

    public function set($name, $data)
    {
        Redis::set($name, $data);
    }

    public function getList($name)
    {
        return Redis::get($name);
    }

    public function clear($name)
    {
        Redis::del($name);
    }
}
