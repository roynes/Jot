<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

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

        $token = JWTAuth::fromUser($user);

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


        if(! $token = JWTAuth::attempt($data->only(['email', 'password']))) {
            return response()->json(['Invalid Credentials'], 401);
        }

        return response()->json(compact('token'));
    }

    public function logout()
    {
        $this->validate(request(), [
            'token' => 'required'
        ]);

        $token = request()->get('token');

        JWTAuth::invalidate($token);

        return response()->json(['You have successfully logged out']);
    }
}
