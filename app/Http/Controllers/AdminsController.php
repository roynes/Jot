<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Group;

class AdminsController extends Controller
{
    public function assignGroup(Client $client, Group $group)
    {
        $client->assignToGroup($group);

        return response()->json(['message' => 'Successfully assigned to a group']);
    }
}