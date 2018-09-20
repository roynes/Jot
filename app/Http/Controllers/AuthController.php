<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserAccountRolesAndPermissionsResource as Resource;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        $this->validate($data = request(), [
            'email' => 'required|string|email|exists:users,email|max:255',
            'password' => 'required|min:6'
        ]);

        if(! $token = auth()->attempt($data->only(['email', 'password']))) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        return response()->json([
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new Resource(
                User::with('account', 'permissions', 'roles')
                    ->whereId(auth()->user()->id)
                    ->first()
            )
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function reloginAs()
    {
        $associatedUser = auth()->user()
            ->associatedUsers
            ->filter(function($user, $key) {
                return $user->hasRole(config('user_roles.super_admin'));
            })
            ->first();

        $token = auth()->login($associatedUser);

        //sau = superadminuser
        $resp["asau"] = new Resource(
            User::with('account', 'permissions', 'roles')
                ->whereId($associatedUser->id)
                ->first()
        );

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
