<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientsController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' =>
            [
                'clients' => Client::all()
            ]
        ]);
    }

    public function create()
    {
        $this->validate(request(), [
            'name' => 'required|string|unique:clients,name',
            'url' => 'required|url',
            'details' => 'string|alpha_dash'
        ]);

        $data = request(['name', 'url', 'details']);

        $client = Client::firstOrCreate($data);

        return response()->json([
            'data' => $client
        ]);
    }
}
