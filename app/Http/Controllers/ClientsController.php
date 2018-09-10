<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientsController extends Controller
{
    public function index()
    {
        return response()
            ->json([
                'clients' => Client::paginate(request()->get('per_page') ?? 6)
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
