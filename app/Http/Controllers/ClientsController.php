<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientsListResource as Resource;
use Intervention\Image\Facades\Image;
use App\Rules\EncodedStringIsImage;
use App\Models\Client;

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

    public function show(Client $client)
    {
        return Resource::collection(
            $client->applyQueryParamRelation()
                ->paginate(request()->get('per_page') ?? 6)
        );

    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json(['message' => 'Deletion Successful']);
    }

    public function create()
    {
        $this->validate(request(), [
            'name' => 'required|string|unique:clients,name',
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

        $client = Client::create([
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
            'data' => $client
        ]);
    }
}
