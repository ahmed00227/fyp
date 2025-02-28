<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded=[];
    public function messages(){
        return $this->hasMany(Message::class);
    }
    public function user1(){
        return $this->belongsTo(User::class,'user1_id');
    }
    public function user2(){
        return $this->belongsTo(User::class,'user2_id');
    }
}
