<?php

namespace App\Models;

use App\Traits\HasAccount;

class Group extends BaseModel
{
    use HasAccount;

    protected $fillable = [
        'name', 'url', 'detail'
    ];
}