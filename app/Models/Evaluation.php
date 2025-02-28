<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to the User who conducted the evaluation
    public function conductedBy()
    {
        return $this->belongsTo(User::class, 'conducted_by');
    }
}
