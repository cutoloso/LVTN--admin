<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    protected $table = 'attribute_group';
    protected $fillable = ['name','alias','att_name_1','att_name_2'];
}
