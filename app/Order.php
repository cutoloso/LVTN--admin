<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['sta_id', 'pay_sta_id', 'pay_mth_id', 'usr_id'];
}
