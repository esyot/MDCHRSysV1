<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSchoolCurricular extends Model
{
    /** @use HasFactory<\Database\Factories\UserSchoolCurricularFactory> */
    use HasFactory;

    protected $guarded = [];

     public function user(){
        return $this->belongsTo(User::class);
    }
}
