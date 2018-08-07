<?php

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