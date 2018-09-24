<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class GroupsListResource extends Resource
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
            'id' => $this->id,
            'name' => $this->name,
            'group_id' => $this->group_id,
            'settings' => $this->settings,
        ];
    }
}
