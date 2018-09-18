<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserAccountResource as Resource;
use App\Models\Account;

class  AccountsController extends Controller
{
    public function index(Account $account)
    {
        return Resource::collection(
            $account->applyQueryParamRelation()
                ->paginate(request()->get('per_page') ?? 6)
        );
    }
}