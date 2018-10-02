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

if (! function_exists('extract_extension_from_image_mime')) {
    /**
     * Returns the image type from a given $mime
     *
     * @param string $mime
     *
     * @return string
     */
    function extract_extension_from_image_mime($mime)
    {
        return explode('/', $mime)[1];
    }
}