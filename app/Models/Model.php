<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Model {
    private function getTable(){
        if (isset($this->table)) {
            return $this->table;
        }

        return str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
    }

    public static function all(){
        $instance = new static;

        return DB::select('select * from ' . $instance->getTable());
    }
}
