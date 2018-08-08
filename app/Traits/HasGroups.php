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
        if(! $this->has('group')->count()) {
            $this->groups()->dissociate();
        }

        $this->groups()->associate($group);
    }
}