<?php

namespace App\Services;

use App\Exceptions\NoCacheAvailableException;
use App\Repositories\ICacheRepository;
use App\Repositories\IMemberRepository;
use Illuminate\Cache\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberService
{

    private $memberRepository;
    /**
     * @var ICacheRepository
     */
    private $cacheRepository;
    /**
     * @var CacheService
     */
    private $cacheService;

    public function __construct(IMemberRepository $memberRepository, CacheService $cacheService)
    {
        $this->memberRepository = $memberRepository;
        $this->cacheService = $cacheService;
    }

    public function list()
    {
        try {
            $members = $this->cacheService->getCache();
        } catch (NoCacheAvailableException $exception) {
            $members = $this->memberRepository->list();
            $this->cacheService->setCache($members);
        } catch (\JsonException $exception) {
            Log::critical('Failed to cache members ', ['reason' => $exception->getMessage()]);
        }
        return collect($members);
    }

    public function create($amount = 10)
    {
        $members = $this->memberRepository->waiting($amount);

        $data = $members->map(function ($member) {
            $memberData =  [
                'fields' => [
                    'Name' => $member->name,
                    'Email' => $member->email,
                ]
            ];
            if ($member->image_url) {
                $memberData['fields']['Photo'] = [
                    ["url" => $member->image_url]
                ];
            }
            return $memberData;
        });

        $createdMembers = $this->memberRepository->create(['records' => $data]);
        if (count($createdMembers['records']) === $members->count()) {
            $this->memberRepository->syncDone($members);
        }
    }

    public function addToWaitingList($data)
    {
        $image_path = null;
        if (Arr::exists($data, 'image')) {
            $image_path = Storage::put('public/uploads', $data['image']);
        }
        return $this->memberRepository->addToWaitingList([
            'name' => $data['name'],
            'email' => $data['email'],
            'image_path' => $image_path
        ]);
    }
}
