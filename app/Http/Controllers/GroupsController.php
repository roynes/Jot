<?php

namespace App\Http\Controllers;

use App\Models\Group;

class GroupsController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' =>
            [
                'groups' => Group::all()
            ]
        ]);
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
