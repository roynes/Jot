<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Group;
use App\Models\User;

class AdminsController extends Controller
{
    public function assignGroup(Client $client, Group $group)
    {
        $client->assignToGroup($group);

        return response()->json(['message' => 'Successfully assigned to a group']);
    }

    public function assignUserToGroup(User $user, Group $group)
    {
        $user->assignGroup($group);

        return response()->json(['message' => 'User successfully assigned to a group']);
    }

    public function assignUserToClient(User $user, Client $client)
    {
        $user->assignClient($client);

        return response()->json(['message' => 'User successfully assigned to a client']);
    }
}