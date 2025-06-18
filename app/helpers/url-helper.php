<?php
function base_url($path = '')
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $domain = $_SERVER['HTTP_HOST'];
    return rtrim($protocol . $domain, '/') . '/' . ltrim($path, '/');
}
