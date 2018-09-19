<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Group;
use App\Models\User;
use Illuminate\Validation\Rule;

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

    public function loginAs()
    {
        $this->validate(request(), [
            'type' => [
                'required', 'string',
                Rule::in(config('user_roles'))
            ],
            'id' => 'numeric|required'
        ]);

        $data = request(['type', 'id']);

        $associatedUser = auth()->user()
            ->associatedUsers
            ->filter(function ($user, $key) use ($data) {
                if(str_contains($data['type'], 'group')) {
                    return $user->hasRole($data['type']) && $user->account->group_id == $data['id'];
                }

                return $user->hasRole($data['type']) && $user->account->client == $data['id'];
            })
            ->first();

        if($associatedUser == null) {
            return response()->json([
                'message' => 'No associated user for this client/group',
            ]);
        }

        $token = auth()->setTTL(config('jwt.ttl') / 2)->login($associatedUser);

        return response()->json([
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'au' => $associatedUser->id
        ]);

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