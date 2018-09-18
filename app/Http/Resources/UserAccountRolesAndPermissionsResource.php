<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserAccountRolesAndPermissionsResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $account = optional($this->account);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'account' => [
                'type' => $account->type,
                'settings' => $account->settings,
                'client_id' => $account->client_id,
                'group_id' => $account->group_id
            ],
            'roles' => $this->roles->pluck('name'),
            'permissions' => $this->permissions->pluck('name'),
        ];
    }
}
