<?php

namespace App\Models;

use App\Models\BaseModel;

class Guide extends BaseModel
{
    protected $table = "guides";

    protected $fillable = ['title', 'content'];
}
