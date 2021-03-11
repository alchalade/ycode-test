<?php

namespace App\Providers;

use App\Models\Member;
use App\Observers\MemberObserver;
use App\Repositories\ApiRepository;
use App\Repositories\CacheRepository;
use App\Repositories\IApiRepository;
use App\Repositories\ICacheRepository;
use App\Repositories\IMemberRepository;
use App\Repositories\MemberRepository;
use App\Services\ApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IMemberRepository::class, MemberRepository::class);
        $this->app->bind(IApiRepository::class, ApiRepository::class);
        $this->app->bind(ICacheRepository::class, CacheRepository::class);
        $this->app->singleton(ApiService::class, ApiService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Member::observe(MemberObserver::class);
    }
}
