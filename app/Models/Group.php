<?php

namespace App\Models;

use App\Traits\HasAccount;
use App\Traits\HasClients;

class Group extends BaseModel
{
    use HasAccount, HasClients;

    protected $fillable = [
        'name', 'settings'
    ];

    protected $casts = [
        'settings' => 'array'
    ];
}