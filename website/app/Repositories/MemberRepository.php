<?php

namespace App\Repositories;

use App\Exceptions\MemberCreationFailedException;
use App\Models\Member;
use App\Services\ApiService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class MemberRepository extends BaseRepository implements IMemberRepository
{

    protected $resource = 'Grid%20View';
    /**
     * @var Member
     */
    private $member;

    public function __construct(Member $member, ApiService $apiService)
    {
        parent::__construct($apiService);
        $this->member = $member;
    }

    /**
     * @param $data
     * @return array
     * @throws MemberCreationFailedException
     */
    public function create($data): array
    {
        $url = $this->buildURL();
        try {
            $response = $this->post($url, $data);
        } catch (ConnectionException $exception) {
            Log::critical('Create new member request failed with following reason : '
                . $exception->getMessage());
            throw new MemberCreationFailedException('The remote server is too busy to '
                . 'take the request now. Please try it again in few seconds');
        } catch (\Exception $exception) {
            Log::critical('Unexpected error while creating member : ' . $exception->getMessage());
            throw new MemberCreationFailedException('Something weird happened'
                . ' on our end. Please try it again later');
        }
        if ($response->status() !== 201 && $response->status() !== 200) {
            Log::critical(
                'Unable to create the member.  : ',
                ['status' => $response->status(), 'body' => $response->body()]
            );
            throw new MemberCreationFailedException('Unable to handle the request. Please verify your data');
        }
        return $response->json();
    }

    public function list()
    {
        $url = $this->buildURL();
        try {
            $response = $this->get($url);
        } catch (ConnectionException $exception) {
            Log::critical('Get all members request failed with following reason : ' . $exception->getMessage());
            throw new MemberCreationFailedException('The remote server is too busy to' .
                ' take the request now. Please try it again in few seconds');
        } catch (\Exception $exception) {
            Log::critical('Unexpected error while getting member list : ' . $exception->getMessage());
            throw new MemberCreationFailedException('Something weird happened on our end.'
                . ' Please try it again later');
        }
        if ($response->status() !== 200) {
            Log::critical(
                'Unable to get the member list.  : ',
                ['url' => $url, 'status' => $response->status(), 'body' => $response->body()]
            );
            throw new MemberCreationFailedException('Unable to handle the request. Please verify your data');
        }
        return $response->json();
    }

    public function waiting($amount)
    {
        return $this->member->waiting($amount);
    }

    public function addToWaitingList($data)
    {
        return $this->member::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'image_path' => $data['image_path'],
        ]);
    }

    public function syncDone(Collection $members)
    {
        $members->each(function ($member) {
            $member->delete();
        });
    }

    protected function buildURL()
    {
        return $this->apiService->baseUrl() . $this->resource;
    }
}
