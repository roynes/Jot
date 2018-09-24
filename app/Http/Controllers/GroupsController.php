<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupsListResource as Resource;
use App\Models\Group;

class GroupsController extends Controller
{
    public function index()
    {
        return Resource::collection(
            Group::paginate(request()
                ->get('per_page') ?? 6
            )
        );

    }

    public function show(Group $group)
    {
        return Resource::collection(
            $group->accounts()
                ->paginate(request()->get('per_page') ?? 6)
        );
    }

    public function create()
    {
        $this->validate(request(), [
            'name' => 'required|string|unique:groups,name',
            'url' => 'required|url',
            'details' => 'string|alpha_dash'
        ]);

        $data = request(['name', 'url', 'details']);

        $group = Group::firstOrCreate($data);

        return response()->json([
            'data' => $group
        ]);
    }
}
