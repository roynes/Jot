<?php

namespace App\Http\Controllers;

use App\Models\Account;

class  AccountsController extends Controller
{
    // Todo: Add codes later
    public function index(Account $account)
    {
        return response()->json(
            $account->applyQueryParamRelation()
                ->paginate(request()->get('per_page') ?? 6)
        );
    }
}