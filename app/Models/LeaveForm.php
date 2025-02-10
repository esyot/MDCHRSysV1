<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveForm extends Model
{
    protected $guarded = [];

    public function endorser(){

        return $this->belongsTo(User::class, 'endorsed_by')
        ->select([
            'id',
            'first_name',
            'last_name',
            'middle_name'
        ]);
    }

    public function substitutes(){
        return $this->hasMany(Substitute::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->select([
            'id',
            'first_name',
            'last_name',
            'middle_name'
        ]);
    }

 
}
