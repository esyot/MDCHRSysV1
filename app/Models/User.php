<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $guarded = ['password'];

    public function personalDetails()
    {
        return $this->hasOne(PersonalDetail::class);
    }

    public function userJobDetails()
    {
        return $this->hasMany(UserJobDetail::class);
    }

    public function userFamilies(){
        return $this->hasMany(UserFamily::class);
    }


    public function userEducationalBackgrounds(){
        return $this->hasMany(UserEducationalBackground::class);
    }


}
