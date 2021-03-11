<?php

namespace App\Services;

use App\Exceptions\NoCacheAvailableException;
use App\Repositories\ICacheRepository;

class CacheService
{
    /**
     * @var ICacheRepository
     */
    private $cacheRepository;
    private $cacheKey = 'members';

    public function __construct(ICacheRepository $cacheRepository)
    {
        $this->cacheRepository = $cacheRepository;
    }

    public function setCache($data)
    {
        $this->cacheRepository->set($this->cacheKey, json_encode($data, JSON_THROW_ON_ERROR));
    }

    public function getCache()
    {
        $cachedData = $this->cacheRepository->getList($this->cacheKey);
        if ($cachedData === null) {
            throw new NoCacheAvailableException('No cache is set for ' . $this->cacheKey);
        }
        return json_decode($cachedData, true, 512, JSON_THROW_ON_ERROR);
    }

    public function clear()
    {
        $this->cacheRepository->clear($this->cacheKey);
    }
}
