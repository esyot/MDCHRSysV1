<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStudy extends Model
{
    /** @use HasFactory<\Database\Factories\UserStudyFactory> */
    use HasFactory;

     public function user(){
        return $this->belongsTo(User::class);
    }
}
