<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $guarded=[];
   public function orders(): BelongsToMany{
       return $this->BelongsToMany(Order::class, 'order_products','product_id','order_id')->withPivot('quantity');
   }
   public function cart() : BelongsTo
   {
       return $this->belongsTo(Cart::class);
   }
}
