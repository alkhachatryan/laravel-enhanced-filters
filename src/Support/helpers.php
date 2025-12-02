<?php

/**
 * In array case-insensitive
 *
 * @param  mixed  $needle
 * @param  array  $haystack
 */
if (!function_exists('in_arrayi')) {
    function in_arrayi($needle, $haystack): bool
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }
}
