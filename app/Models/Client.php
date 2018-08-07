<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'url', 'detail'
    ];

    public function groups()
    {
        return $this->belongsTo(Group::class, 'id');
    }

    public function assignToGroup($group)
    {
        if(! $this->has('groups')->count()) {
            $this->groups()->dissociate();
        }

        $this->groups()->associate($group);
    }
}