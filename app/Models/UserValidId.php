<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserValidId extends Model
{
    /** @use HasFactory<\Database\Factories\UserValidIdFactory> */
    use HasFactory;

    protected $guarded = [];

     public function user(){
        return $this->belongsTo(User::class);
    }
}
