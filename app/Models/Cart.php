<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    protected $guarded=[];
    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
