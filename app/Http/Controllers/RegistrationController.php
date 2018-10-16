<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Traits\RegistersAndAssigns;

class RegistrationController extends Controller
{
    use RegistersAndAssigns;
}