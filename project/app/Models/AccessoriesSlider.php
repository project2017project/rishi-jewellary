<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessoriesSlider extends Model
{
    protected $fillable = ['title','url','photo'];
    public $timestamps = false;
}
