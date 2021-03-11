<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class MemberListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource['id'],
            'name' => $this->resource['fields']['Name'],
            'email' => $this->resource['fields']['Email'],
            'avatar' => Arr::exists($this->resource['fields'], 'Photo') ?
                $this->resource['fields']['Photo'][0]['thumbnails']['small']['url'] : null
        ];
    }
}
