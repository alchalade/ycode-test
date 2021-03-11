<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Services\CacheService;
use App\Services\MemberService;
use Illuminate\Console\Command;

class create_members extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates up to 10 members';
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
     */
    public function __construct(MemberService  $memberService, CacheService $cacheService)
    {
        parent::__construct();
        $this->memberService = $memberService;
        $this->cacheService = $cacheService;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->memberService->create();
        $this->cacheService->clear();
    }
}
