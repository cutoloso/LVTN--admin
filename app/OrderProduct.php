<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = "order_product";
    protected $fillable = ['ord_id','pro_id','price','quantity', 'warranty_start', 'warranty_end'];
    public $timestamps = false;
}
