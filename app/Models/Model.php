<?php

namespace App\Models;

class Model {
    private function getTable(){
        return isset($this->table) ? $this->table : str_plural(strtolower(get_class($this)));
    }

    public function all(){
        return DB::select('select * from ' . $this->getTable());
    }
}
