<?php

namespace App\Repositories;


use App\Services\ApiService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class BaseRepository
{
    protected $resource = null;
    /**
     * @var ApiService
     */
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    protected $defaultHeaders = [
        'accept' => 'application/json',
        'content-type' => 'application/json'
    ];

    public function get($url, $data = [], $includeBearer = true, $headers = [], $mergeHeaders = true): \Illuminate\Http\Client\Response
    {
        $request = Http::withHeaders($this->requestHeaders($headers, $mergeHeaders));
        return $this->tokenizeRequest($request, $includeBearer)->get($url, $data);
    }

    public function post($url, $data, $includeBearer = true, $headers = [], $mergeHeaders = true): \Illuminate\Http\Client\Response
    {
        $request = Http::withHeaders($this->requestHeaders($headers, $mergeHeaders));
        return $this->tokenizeRequest($request, $includeBearer)->post($url, $data);
    }

    protected function requestHeaders($headers, $mergeHeaders): array
    {
        return $mergeHeaders ? $this->defaultHeaders + $headers : $headers;
    }

    protected function tokenizeRequest(PendingRequest $request, $includeBearer)
    {
        return $includeBearer ? $request->withToken($this->apiService->apiKey()) : $request;
    }


    protected function buildURL()
    {
        throw new \BadMethodCallException('this part should re-defined by each consumer');
    }
}
