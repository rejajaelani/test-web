<?php
function route($path = '')
{
    $base = 'http://' . $_SERVER['HTTP_HOST'] . '/test-web';
    return $base . '/' . ltrim($path, '/');
}

function publicUrl($path)
{
    $base = 'http://' . $_SERVER['HTTP_HOST'] . '/test-web/public';
    return $base . '/' . ltrim($path, '/');
}
