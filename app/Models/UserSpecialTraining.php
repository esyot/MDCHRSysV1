<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSpecialTraining extends Model
{
    /** @use HasFactory<\Database\Factories\UserSpecialTrainingFactory> */
    use HasFactory;


    protected $guarded = [];

     public function user(){
        return $this->belongsTo(User::class);
    }
}
