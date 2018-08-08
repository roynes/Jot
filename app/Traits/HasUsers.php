<?php

namespace App\Traits;

use App\Models\User;

trait HasUsers
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignUser(User $user)
    {
        if($this->has('user')->count())
        {
            $this->user()->dissociate($user);
        }

        $this->user()->associate($user);
        $this->save();
    }
}