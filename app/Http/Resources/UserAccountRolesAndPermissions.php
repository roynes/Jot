<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserAccountRolesAndPermissions extends Resource
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
            'name' => $this->name,
            'email' => $this->email,
            'account' => [
              'type' => $account->type,
              'settings' => $account->settings
            ],
            'roles' => $this->roles->pluck('name'),
            'permissions' => $this->permissions->pluck('name'),
        ];
    }
}
