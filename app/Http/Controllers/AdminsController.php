<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserAccountRolesAndPermissionsResource as Resource;
use Illuminate\Validation\Rule;
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

                return $user->hasRole($data['type']) && $user->account->client_id == $data['id'];
            })
            ->first();

        if($associatedUser == null) {
            return response()->json([
                'message' => 'No associated user for this client/group',
                'authenticated' => false
            ]);
        }

        $token = auth()->setTTL(config('jwt.ttl') / 2)->login($associatedUser);

        return response()->json([
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new Resource(
                User::with('account', 'permissions', 'roles')
                    ->whereId($associatedUser->id)
                    ->first()
            )
        ]);
    }
}