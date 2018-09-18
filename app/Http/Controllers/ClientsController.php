<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientsListResource as Resource;
use App\Models\Client;
use App\Models\Group;

class ClientsController extends Controller
{
    public function index()
    {
        return Resource::collection(
            Client::paginate(
                request()->get('per_page') ?? 6
            )
        );

    }

    public function show(Group $group)
    {
        return Resource::collection(
            $group->applyQueryParamRelation()
                ->paginate(request()->get('per_page') ?? 6)
        );

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
