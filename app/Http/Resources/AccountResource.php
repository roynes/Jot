<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AccountResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => $this->whenLoaded('user'),
            'aid' => $this->id,
            'type' => $this->type,
            'client_id' => $this->client_id,
            'group_id' => $this->group_id,
            'settings' => $this->settings
        ];
    }
}
