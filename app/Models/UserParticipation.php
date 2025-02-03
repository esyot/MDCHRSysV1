<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserParticipation extends Model
{
    /** @use HasFactory<\Database\Factories\UserParticipationFactory> */
    use HasFactory;

     public function user(){
        return $this->belongsTo(User::class);
    }
}
