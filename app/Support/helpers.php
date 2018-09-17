<?php
use Illuminate\Support\Arr;

if (! function_exists('get_roles')) {
    /**
     * Retrieves all the roles from config
     *
     * @param string|array $roles
     *
     * @return array
     */
    function get_roles($roles)
    {
        if(is_array($roles)) {
            return array_flatten( array_only(
                config('user_roles'),
                $roles
            ));
        }

        if(is_string($roles)) {
            return [
                array_get(config('user_roles'), $roles)
            ];
        }

        return [];
    }
}

if (! function_exists('only')) {
    /**
     * Returns the range of value in the specified $array $keys
     *
     * @param $array
     * @param mixed ...$keys
     *
     * @return array
     */
    function only($array, ...$keys)
    {
        $result = [];

        foreach ($keys as $key) {
           $result[] = Arr::get($array, $key);
        }

        return $result;
    }
}