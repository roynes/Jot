<?php

namespace App\Models;

use App\Traits\HasClients;
use App\Traits\HasGroups;
use App\Traits\HasUsers;

class Account extends BaseModel
{
    use HasUsers, HasGroups, HasClients;

    protected $fillable = [
        'user_id', 'group_id', 'client_id', 'settings', 'type'
    ];

    protected $casts = [
        'settings' => 'array'
    ];

    public function scopeFilterGroup($query, $groupId)
    {
        return $query->whereGroupId($groupId)->where('user_id', '!=', auth()->user()->id);
    }
}
