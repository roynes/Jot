<?php

namespace App\Traits;

use App\Models\Account;

trait HasAccount
{
    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function assignAccount(Account $account)
    {
        $this->account()->save($account);
    }
}