<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAwardReceive extends Model
{
    /** @use HasFactory<\Database\Factories\UserAwardReceiveFactory> */
    use HasFactory;

    protected $guarded = [];

     public function user(){
        return $this->belongsTo(User::class);
    }
}
