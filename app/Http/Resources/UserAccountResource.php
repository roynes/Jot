<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserAccountResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = optional($this->whenLoaded('user'));

        return [
            'uid' => $user->id,
            'aid' => $this->id,
            'type' => $this->type,
            'name' => $user->name,
            'email' => $user->email,
            'client_id' => $this->client_id,
            'group_id' => $this->group_id,
            'settings' => $this->settings
        ];
    }
}
