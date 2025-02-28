<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $guarded=[];
    public function products(): BelongsToMany{
        return $this->BelongsToMany(Order::class, 'order_products','order_id','product_id')->withPivot('quantity');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
