<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeGroupAttribute extends Model
{
    protected $table = 'attributeGroup_attribute';
    protected $fillable = ['att_gr_id','att_id'];
    public $timestamps = false;
}
