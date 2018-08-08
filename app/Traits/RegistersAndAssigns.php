<?php

namespace App\Traits;

use Spatie\Permission\Models\Role;
use App\Models\Account;
use App\Models\Client;
use App\Models\Group;
use App\Models\User;

trait RegistersAndAssigns
{
    public function register()
    {
        $this->createUser();

        return response()->json(['message' => 'Registration Successful']);
    }

    public function registerGroupUser()
    {
        $user = $this->createUser();

        $this->assign(
            $user,
            Group::find($this->request->get('group_id')),
            config('user_roles.group_end_user')
        );

        return response()->json(['message' => 'Registration Successful']);
    }

    public function registerClientUser()
    {
        $user = $this->createUser();

        $this->assign(
            $user,
            Client::find($this->request->get('client_id')),
            config('user_roles.end_user')
        );

        return response()->json(['message' => 'Registration Successful']);
    }

    public function registerGroupAdmin()
    {
        $user = $this->createUser();

        $this->assign(
            $user,
            Group::find($this->request->get('group_id')),
            config('user_roles.group_admin')
        );

        return response()->json(['message' => 'Registration Successful']);
    }

    public function registerClientAdmin()
    {
        $user = $this->createUser();

        $this->assign(
            $user,
            Client::find($this->request->get('client_id')),
            config('user_roles.client_admin')
        );

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