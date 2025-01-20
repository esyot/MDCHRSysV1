<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDetail extends Model
{
    /** @use HasFactory<\Database\Factories\PersonalDetailFactory> */
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);  // Many-to-One relationship
    }

    public function permanentAddress()
    {
        return $this->belongsTo(Address::class, 'permanent_address_id');
    }

    public function residentialAddress()
    {
        return $this->belongsTo(Address::class, 'residential_address_id');
    }



}
