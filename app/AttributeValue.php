<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_value';
    protected $fillable = ['pro_id','att_id','att_value'];
    public $timestamps = false;
}
