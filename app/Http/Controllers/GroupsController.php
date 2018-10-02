<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupsListResource as Resource;
use App\Models\Group;
use App\Rules\EncodedStringIsImage;
use Intervention\Image\Facades\Image;

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

    public function create()
    {
        $this->validate(request(), [
            'name' => 'required|string|unique:groups,name',
            'email' => 'nullable|email',
            'street' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|numeric',
            'description' => 'nullable|present|string',
            'logo' => ['nullable', new EncodedStringIsImage]
        ]);

        $img = Image::make(request()->logo);
        $filename = str_random().'.'.extract_extension_from_image_mime($img->mime);

        $img->save(config('filesystems.disks.public.root').DIRECTORY_SEPARATOR.$filename);

        $group = Group::create([
            'name' => request()->name,
            'settings' => [
                'email' => request()->email,
                'street' => request()->street,
                'state' => request()->state,
                'city' => request()->city,
                'zip_code' => request()->zip_code,
                'description' => request()->description,
                'logo' => asset('storage/'.$filename)
            ]
        ]);

        return response()->json([
            'data' => $group
        ]);
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return response()->json(['message' => 'Deletion Successful']);
    }
}