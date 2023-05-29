<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'price', 'times', 'start_date','end_date','cart_qty','cart_value','description'];
    public $timestamps = false;
}
