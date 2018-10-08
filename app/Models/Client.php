<?php

namespace App\Models;

use App\Traits\HasGroups;

class Client extends BaseModel
{
    use HasGroups;

    protected $fillable = [
        'name', 'url', 'detail'
    ];

    protected $casts = [
        'settings' => 'array'
    ];

    public function groups()
    {
        return $this->group();
    }

    public function assignToGroup(Group $group)
    {
        $this->assignGroup($group);
    }

    public function scopeByGroupOf($query, $id)
    {
        return $query->whereGroupId($id);
    }
}