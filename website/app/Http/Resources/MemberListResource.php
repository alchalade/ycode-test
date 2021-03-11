<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class MemberListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $photo = Arr::exists($this->resource['fields'], 'Photo') ? $this->resource['fields']['Photo'][0] : null;
        $avatar = $photo && Arr::exists($photo, 'thumbnails') ? $photo['thumbnails']['small']['url'] : null;

        return [
            'id' => $this->resource['id'],
            'name' => $this->resource['fields']['Name'],
            'email' => $this->resource['fields']['Email'],
            'avatar' => $avatar,
        ];
    }
}
