<?php

use Engine\Collection;
use Engine\Config;
use Engine\View;

if (!function_exists('collect')) {
    function collect(array $array)
    {
        return new Collection($array);
    }
}

if (!function_exists('path')) {
    function path($path)
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/$path";
    }
}

if (!function_exists('resources_path')) {
    function resources_path($path)
    {
        return path("resources/$path");
    }
}

if (!function_exists('tmp_path')) {
    function tmp_path($path)
    {
        return path("tmp/$path");
    }
}

if (!function_exists('config')) {
    function config($key)
    {
        $config = new Config();

        return $config->get($key);
    }
}

if (!function_exists('view')) {
    function view($path)
    {
        $view = new View($path);

        return $view;
    }
}

if (!function_exists('to_object')) {
    function to_object($data)
    {
        return json_decode(json_encode($data));
    }
}

if (!function_exists('redirect')) {
    function redirect($url)
    {
        return header("Location: $url");
    }
}

if (!function_exists('pluck')) {
    function pluck($data, $column)
    {
        $list = [];
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                $list[] = $item[$column];
            } elseif (is_object($item)) {
                $list[] = $item->$column;
            }
        }

        return $list;
    }
}

if (!function_exists('resources_url')) {
    function resources_url($path)
    {
        return "/resources/$path";
    }
}
