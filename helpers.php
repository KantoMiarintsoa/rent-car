<?php
function get_or_default($key, $default)
{
    if (isset($_GET[$key])) {
        return $_GET[$key];
    }
    return $default;
}
