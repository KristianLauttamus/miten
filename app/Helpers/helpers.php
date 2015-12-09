<?php
function flash($title = null, $message = null)
{
    $flash = app('App\Models\FlashMessage');
    return $flash->create($title, $message);
}
