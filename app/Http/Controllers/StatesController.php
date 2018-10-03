<?php

namespace App\Http\Controllers;

use App\Models\State;

class StatesController extends Controller
{
    public function index()
    {
        return response()->json([
            'states' => State::all()
        ]);
    }
}