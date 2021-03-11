<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberCreateRequest;
use App\Http\Resources\MemberListResource;
use App\Http\Resources\MemberResource;
use App\Services\MemberService;

class MemberController extends Controller
{

    /**
     * @var MemberService
     */
    private $memberService;

    /**
     * MemberController constructor.
     * @param MemberService $memberService
     */
    public function __construct(MemberService $memberService)
    {

        $this->memberService = $memberService;
    }

    /***/
    public function index()
    {
        $members = $this->memberService->list();
        return MemberListResource::collection($members['records']);
    }

    /**
     * @param MemberCreateRequest $request
     */
    public function store(MemberCreateRequest $request )
    {
        $member =$this->memberService->addToWaitingList($request->validated());
        return (MemberResource::make($member))->response()->setStatusCode(201);
    }

}
