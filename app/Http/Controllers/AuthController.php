<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    public function register()
    {
        $this->validate($data = request(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required|min:6'
        ]);

        $user = $this->registerUser($data->only(['email', 'name', 'password']));

        $token = auth()->login($user);

        return response()->json(compact('token'));
    }

    private function registerUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
            'email' => $data['email']
        ]);
    }

    public function login()
    {
        $this->validate($data = request(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|min:6'
        ]);

        if(! $token = auth()->attempt($data->only(['email', 'password']))) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
