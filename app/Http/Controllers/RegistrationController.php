<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Traits\RegistersAndAssigns;

class RegistrationController extends Controller
{
    use RegistersAndAssigns;

    /**
     * @var RegisterRequest
     */
    protected $request;

    /**
     * RegistrationController constructor.
     *
     * @param RegisterRequest $request
     */
    public function __construct(RegisterRequest $request)
    {
        $this->request = $request;
    }
}