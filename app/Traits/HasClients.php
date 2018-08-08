<?php

namespace App\Traits;

use App\Models\Client;

trait HasClients
{
    public function client()
    {
        return $this->belongsTo(Client::class, 'id');
    }

    public function assignClient(Client $client)
    {
        if($this->has('client')->count()) {
            $this->client()->dissociate();
        }

        return $this->client()->associate($client);
    }
}