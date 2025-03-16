<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $guarded = [];


    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id', 'id')
            ->select([
                'id',
                'first_name',
                'last_name',
                'middle_name',
            ]);
    }
}
