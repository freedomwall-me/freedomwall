<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserResource extends JsonResource
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
                'email' => $this->email,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'email_verified_at' => $this->email_verified_at
            ],
            'walls' => WallResource::collection($this->walls()),
        ];
    }
}
