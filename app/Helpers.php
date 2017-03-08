<?php

if (!function_exists('asset')) {
    function asset($path)
    {
        echo 'http://' . $_SERVER['HTTP_HOST'] . '/public/' . $path;
    }
}

if (!function_exists('view')) {
    function view($view, $params = [])
    {
        return View::make($view, $params);
    }
}

if (!function_exists('includeView')) {
    function includeView($view, $params = [])
    {
        echo view($view, $params);
    }
}


if (!function_exists('array_filter_recursive')) {
    function array_filter_recursive($input)
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = array_filter_recursive($value);
            }
        }

        return array_filter($input);
    }
}
