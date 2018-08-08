<?php

namespace App\Traits;

use App\Models\Group;

trait HasGroups
{
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function assignGroup(Group $group)
    {
        if(! $this->has('group')->count()) {
            $this->group()->dissociate();
        }

        $this->group()->associate($group);
        $this->save();
    }
}