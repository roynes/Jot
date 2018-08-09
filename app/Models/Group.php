<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAccount;

class Group extends Model
{
    use HasAccount;

    protected $fillable = [
        'name', 'url', 'detail'
    ];
}