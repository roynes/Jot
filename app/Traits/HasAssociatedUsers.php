<?php

namespace App\Traits;

use App\Models\User;

trait HasAssociatedUsers
{
    public function associatedUsers()
    {
        return $this->belongsToMany(User::class, 'associated_users', 'user_id', 'associated_user_id');
    }

    public function associateWith($user)
    {
        return $this->associatedUsers()->save($user);
    }
}