<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;

    protected $guarded = [];

    public function PersonalDetail()
    {
        $this->belongsTo(PersonalDetail::class);
    }

    public function userReferences()
    {
        return $this->hasMany(UserReference::class); 
    }
}
