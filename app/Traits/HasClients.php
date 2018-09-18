<?php

namespace App\Traits;

use App\Models\Client;

trait HasClients
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function assignClient(Client $client)
    {
        if($this->has('client')->count()) {
            $this->client()->dissociate();
        }

        $this->client()->associate($client);
        $this->save();
    }
}