<?php

namespace App\Models;

//use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Guide extends BaseModel
{
    protected $table = "guides";

    protected $fillable = ['title', 'description'];
}
