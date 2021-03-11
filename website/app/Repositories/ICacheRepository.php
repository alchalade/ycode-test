<?php

namespace App\Repositories;

interface ICacheRepository
{
    /**
     * Sets a key and stores the data with it
     */
    public function set($name, $data);

    /**
     * Reads the value of the key and gives the data back
     */
    public function getList($name);

    /**
     * Clear all data for the given key
     */
    public function clear($name);
}
