<?php

namespace App\Observers;

use App\Models\Member;
use Illuminate\Support\Facades\Log;

class MemberObserver
{
    public function created(Member $member): void
    {
        Log::debug('MEMBER OBSERVER CREATED');
        //TODO: use APP_URL from .env file on server
        if($member->image_path !== null) {
            $member->image_url='https://placeimg.com/640/480/people.jpg?r='.time();
            $member->save();
        }
    }
}
