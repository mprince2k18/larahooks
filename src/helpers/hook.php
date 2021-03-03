<?php

use Mprince\Larahooks\Facades\Hook;

if (!function_exists('hook_action')) {
    function do_action($name, $params = [])
    {
        \Mprince\Larahooks\Hook::action($name, $params);
    }
}

if (!function_exists('hook_filter')) {
    function apply_filters($name, $data = [], $params = [])
    {
        return \Mprince\Larahooks\Hook::filter($name, $data, $params);
    }
}

function hookr()
{
    return $hookr = new \Mprince\Larahooks\Hook;
}
