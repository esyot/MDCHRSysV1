<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducationalBackground extends Model
{
    /** @use HasFactory<\Database\Factories\UserEducationalBackgroundFactory> */
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
