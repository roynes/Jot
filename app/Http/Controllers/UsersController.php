<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserAccountRolesAndPermissionsResource as Resource;

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
            ->json(new Resource(
                $user->applyQueryParamRelation()
                    ->whereId($user->id)
                    ->first()
            )
        );
    }
}