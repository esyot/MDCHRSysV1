<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFamily extends Model
{
    /** @use HasFactory<\Database\Factories\UserFamilyFactory> */
    use HasFactory;


    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
