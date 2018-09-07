<?php

namespace App\Http\Controllers;

use App\Models\User;

class UsersController extends Controller
{
    /**
     * Fetch a specific User
     *
     * @param $id
     * @return mixed
     */
    public function show(User $user)
    {
        return response()
            ->json($user->applyQueryParamRelation()->whereId($user->id)->first());
    }
}