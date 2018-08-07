<?php

namespace App\Traits;

use App\Models\Group;

trait HasGroups
{
    public function group()
    {
        return $this->belongsTo(Group::class, 'id');
    }

    public function assignGroup(Group $group)
    {
        return $this->group()->associate($group);
    }
}