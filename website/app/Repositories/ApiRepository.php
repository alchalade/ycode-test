<?php

namespace App\Repositories;
//normally this kind of sensetive data should be read out form secret source
class ApiRepository implements IApiRepository
{
    public function apiKey(): string
    {
        return config()->get('air_table.api_key');
    }

    public function baseUrl(): string
    {
        return config()->get('air_table.base_url');
    }
}
