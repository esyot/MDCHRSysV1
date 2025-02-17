<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelForm extends Model
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
    
    public function user(){
        return $this->belongsTo(User::class)->select([
            'id',
            'first_name',
            'last_name',
            'middle_name'
        ]);
    }

    public function userJobDetail()
    {
        return $this->hasOne(UserJobDetail::class, 'user_id', 'user_id')
                    ->oldest('date_hired')
                    ->select([
                        'user_id',
                        'date_hired'
        ]);
    }

    public function substitutes()
    {
        return $this->hasMany(Substitute::class, 'travel_form_id');
    }

}
