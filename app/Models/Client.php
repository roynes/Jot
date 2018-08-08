<?php

namespace App\Models;

use App\Traits\HasGroups;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasGroups;

    protected $fillable = [
        'name', 'url', 'detail'
    ];

    public function groups()
    {
        return $this->group();
    }

    public function assignToGroup(Group $group)
    {
        $this->assignGroup($group);
    }
}