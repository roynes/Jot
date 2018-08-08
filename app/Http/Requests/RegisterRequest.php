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
        $defaults = [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required|min:6'
        ];

        if($this->routeCheck(route('register.group.admin'), route('register.group.end.user'))
            && request()->method() === 'POST'
        ) {
            return array_merge(
                $defaults,
                ['group_id' => 'numeric|required|exists:groups,id']
            );
        }

        if($this->routeCheck(route('register.client.admin'), route('register.client.end.user'))
            && request()->method() === 'POST'
        ) {
            return array_merge(
                $defaults,
                ['client_id' => 'numeric|required|exists:clients,id']
            );
        }

        return $defaults;
    }

    /**
     * Checks the given request url
     *
     * @param $url
     * @return bool
     */
    private function routeCheck(...$url)
    {
        $curUrl = request()->url();
        $match = false;

        foreach($url as $route)
        {
            if($route === $curUrl)
                $match = true;
        }

        return $match;
    }
}
