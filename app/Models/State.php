<?php

namespace App\Models;

class State extends BaseModel
{
    protected $fillable = [
        'name', 'abbr'
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];
}
