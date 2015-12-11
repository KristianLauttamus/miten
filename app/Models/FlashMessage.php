<?php

namespace App\Models;

use Illuminate\Http\Request;

class FlashMessage
{
    protected $request;

    public function create(Request $request, $title = null, $message = null, $type = "success", $overlay = false, $timer = 1700)
    {
        if (func_num_args() == 1) {
            $this->request = $request;
            return $this;
        } else if (func_num_args() == 0) {
            return dd("error");
        }
        return $request->session()->flash('flash_message', [
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'overlay' => $overlay,
            'timer' => $timer,
        ]);
    }
    public function error($title = null, $message = null)
    {
        return $this->create($this->request, $title, $message, "error");
    }
}
