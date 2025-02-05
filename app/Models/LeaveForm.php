<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveForm extends Model
{
    protected $guarded = [];

    public function substitutes(){
        return $this->hasMany(Substitute::class);
    }
}
