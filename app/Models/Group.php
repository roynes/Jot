<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Group extends Model
{
    protected $fillable = [
        'name', 'url', 'detail'
    ];

    public function clients()
    {
        return $this->hasMany(Client::class, 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id');
    }
}