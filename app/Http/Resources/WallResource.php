<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class WallResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'properties' => [
                'title' => $this->title,
                'tags' => json_decode($this->tags, true),
                'body' => bzdecompress($this->body),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'publish_status' => $this->publish_status
            ],
            'user' => $this->user(),
        ];
    }
}
