<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvalTemplate extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->hasMany(EvalTemplateCategory::class);
    }
}
