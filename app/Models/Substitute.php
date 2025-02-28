<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Substitute extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class)->select([
            'id',
            'first_name',
            'last_name',
            'middle_name'
        ]);
    }

}
