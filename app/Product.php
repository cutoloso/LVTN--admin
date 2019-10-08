<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name','code','alias','price','price_sale','parent','quatity','warranty','active','description','sup_id','bra_id','att_gr_id','best_feature','best_sale'];
    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
}
