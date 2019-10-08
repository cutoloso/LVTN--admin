<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_image';
    protected $fillable = ['pro_id', 'img', 'active', 'front', 'back', 'above', 'below', 'left', 'right'];
    public $timestamps = false;
}
