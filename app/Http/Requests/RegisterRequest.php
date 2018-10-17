<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         * To keep out error when running route:list
         */
        if(app()->runningInConsole()) {
            return [];
        }

        $defaults = [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'role' => 'required|exists:roles,name',
            'client_id' => 'nullable|numeric|exists:clients,id',
            'group_id' => 'nullable|numeric|exists:groups,id'
        ];

        return $defaults;
    }
}
