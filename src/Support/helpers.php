<?php

/**
 * In array case-insensitive
 *
 * @param  mixed  $needle
 * @param  array  $haystack
 */
function in_arrayi($needle, $haystack): bool
{
    return in_array(strtolower($needle), array_map('strtolower', $haystack));
}
