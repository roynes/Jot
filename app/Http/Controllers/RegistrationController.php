<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Group;
use App\Models\User;

class RegistrationController extends Controller
{
    public function register()
    {
        $token = auth()->login($this->validateAndCreate());

        return response()->json(compact('token'));
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
     * @param array keys
     * @return User
     */
    private function validateAndCreate(array $keys = [])
    {
        $keyData = array_merge([
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required|min:6'
        ], $keys);

        $this->validate($data = request(), $keyData);

        return $this->registerUser($data->only(['email', 'name', 'password']));
    }

    public function registerGroupUser()
    {
        $user = $this->validateAndCreate(['group_id' => 'numeric|required|exists:groups,id']);

        $user->assignGroup(Group::find(request()->get('group_id')));

        return response()->json(['message' => 'Registration Successful']);
    }

    public function registerClientUser()
    {
        $user = $this->validateAndCreate(['client_id' => 'numeric|required|exists:clients,id']);

        $user->assignClient(Client::find(request()->get('client_id')));

        return response()->json(['message' => 'Registration Successful']);
    }
}