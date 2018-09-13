<?php

namespace App\Http\Controllers;


class AuthController extends Controller
{
    public function login()
    {
        $this->validate($data = request(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|min:6'
        ]);

        if(! $token = auth()->attempt($data->only(['email', 'password']))) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        return response()->json([
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function loginTo()
    {
        // params should be: client/group to redirect to. probably
    }

}
