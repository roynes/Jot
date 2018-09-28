<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupsListResource as Resource;
use App\Models\Group;
use App\Rules\EncodedStringIsImage;

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
        //Todo: Continue Group Add

        $this->validate(request(), [
            'name' => 'required|string|unique:groups,name',
            'street' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|numeric',
            'description' => 'string',
            'logo' => ['required', new EncodedStringIsImage]
        ]);

        $data = request(['name', 'street', 'state', 'zip_code', 'description', 'logo']);

        $data['details'] = json_encode([
            'name' => $data['name'],
            'street' => $data['street'],
            'state' => $data['state'],
            'zip_code' => $data['zip_code'],
            'description' => $data['description']
        ]);

        $img = Image::make($data['logo']);


        unset($data['street'], $data['state'], $data['zip_code'], $data['description']);

        $group = Group::firstOrCreate($data);

        return response()->json([
            'data' => $group
        ]);
    }
}
