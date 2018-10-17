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
        $password = str_random();

        $user = $this->registerUser(array_merge(request()->only(['email', 'name']), compact('password')));

        $this->assignAccountAndRoles($user, $request->role);
        $this->assignToSubdomain($user, $request->client_id, $request->group_id);

        return response()->json([
            'message' => 'Registration Successful',
            'user' => [
                'email' => $user->email,
                'password' => $password
            ]
        ]);
    }

    /**
     * Creates user from the given data
     *
     * @param array $data
     * @return mixed|User
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
     * Assigns the given $user to a $subDomain
     *
     * @param User $user
     * @param mixed ...$subDomain
     */
    public function assignToSubdomain(User $user, ...$subDomain)
    {
        list($client, $group) = $subDomain;

        if (!is_null($client)) {
            $user->account->assignClient(Client::find($client));
        }

        if(!is_null($group)) {
            $user->account->assignGroup(Group::find($group));
        }
    }
}