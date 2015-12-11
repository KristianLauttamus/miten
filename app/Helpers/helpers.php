<?php
function flash(\Illuminate\Http\Request $request, $title = null, $message = null)
{
    $flash = app('App\Models\FlashMessage');
    if ($title == null && $message == null) {
        return $flash->create($request);
    }
    return $flash->create($request, $title, $message);
}
