<?php

namespace App\Console\Commands;

use App\Repositories\ICacheRepository;
use App\Services\CacheService;
use App\Services\MemberService;
use Illuminate\Console\Command;

class snyc_members extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronizes all members';
    /**
     * @var MemberService
     */
    private $memberService;
    /**
     * @var CacheService
     */
    private $cacheService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MemberService  $memberService, CacheService $cacheService)
    {
        $this->memberService = $memberService;

        $this->cacheService = $cacheService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->cacheService->clear();
        $this->memberService->list();
    }
}
