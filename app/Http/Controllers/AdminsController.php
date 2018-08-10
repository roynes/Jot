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

    public function loginAsGroupAdmin()
    {
        $associatedUser = auth()->user()
            ->associatedUsers
            ->filter(function ($value, $key) {
                return $value->hasRole(config('user_roles.group_admin'));
            })
            ->first();

        if($associatedUser->account->group->id == request('group_id'))
        {
            $token = auth()->login($associatedUser);

            return response()->json([
                'message' => 'Successfully logged in as group admin',
                'data' => [
                    'token' => $token,
                    'redirect_to' => Group::find(1)->url
                ]
            ]);
        }

        return response()->json(['message' => 'Associated user not found']);
    }
}