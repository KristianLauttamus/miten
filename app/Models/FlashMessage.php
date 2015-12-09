<?php

namespace App\Models;

class FlashMessage
{
    public function create($title = null, $message = null, $type = "success", $overlay = false, $timer = 1700)
    {
        if (func_num_args() == 0) {
            return $this;
        }
        return session()->flash('flash_message', [
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'overlay' => $overlay,
            'timer' => $timer,
        ]);
    }
    public function error($title = null, $message = null)
    {
        return $this->create($title, $message, "error");
    }
}
