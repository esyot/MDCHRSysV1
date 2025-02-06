<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtherDetail extends Model
{
    /** @use HasFactory<\Database\Factories\UserOtherDetailFactory> */
    use HasFactory;


    protected $guarded = [];
    
     public function user(){
        return $this->belongsTo(User::class);
    }

}
