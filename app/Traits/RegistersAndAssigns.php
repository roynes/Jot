<?php

namespace App\Traits;

use App\Http\Requests\RegisterRequest;
use Spatie\Permission\Models\Role;
use App\Models\Account;
use App\Models\Client;
use App\Models\Group;
use App\Models\User;

trait RegistersAndAssigns
{
    public function register(RegisterRequest $request)
    {
        $user = $this->createUser();

        $user->assignRole([$request->role]);

        if (!is_null($client = $request->client_id)) {
            $user->assignClient(Client::find($client));
        }

        if(!is_null($group = $request->group_id)) {
            $user->assignGroup(Group::find($group));
        }

        $user->account()->create([
            'type' => $request->role,
            'client_id' => $request->client_id,
            'group_id' => $request->group_id,
        ]);

        return response()->json(['message' => 'Registration Successful']);
    }

    /**
     * Creates user from the given data
     *
     * @param array $data
     * @return mixed
     */
    private function registerUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
            'email' => $data['email']
        ]);
    }

    /**
     * Validates and returns the newly created user
     *
     * @return User
     */
    private function createUser()
    {
        return $this->registerUser($this->request->only(['email', 'name', 'password']));
    }

    /**
     * Assigns account and role to a specific user
     *
     * @param User $user
     * @param string $role
     */
    private function assignAccountAndRoles(User $user, string $role)
    {
        $user->assignRole(Role::findByName($role));

        $user->assignAccount(Account::create([
            'type' => $role
        ]));
    }

    /**
     * Assigns the given User to account and a domain
     *
     * @param User $user
     * @param $type
     * @param $role
     * @return mixed
     */
    public function assign(User $user, $type, $role)
    {
        $this->assignAccountAndRoles($user, $role);

        if($type instanceof Client) {
            return $user->account->assignClient($type);
        }

        return $user->account->assignGroup($type);
    }
}