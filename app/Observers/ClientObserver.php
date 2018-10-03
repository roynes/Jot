<?php

namespace App\Observers;

use App\Models\Client;

class ClientObserver
{
    public function creating(Client $group)
    {
        $group->settings = json_encode($group->settings);
    }
}