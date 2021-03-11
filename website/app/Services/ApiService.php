<?php


namespace App\Services;

use App\Repositories\IApiRepository;

class ApiService
{
    /**
     */
    private $apiRepository;

    public function __construct(IApiRepository $apiRepository)
    {
        $this->apiRepository = $apiRepository;
    }

    public function baseUrl()
    {
        return $this->apiRepository->baseUrl();
    }

    public function apiKey()
    {
        return $this->apiRepository->apiKey();
    }
}
