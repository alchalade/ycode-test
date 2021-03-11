<?php


namespace App\Repositories;


interface IApiRepository
{
    /**
     * Gives the api url back
     */
    public function baseUrl():string;

    /**
     *  Gives the api key back
     */
    public function apiKey(): string;

}
