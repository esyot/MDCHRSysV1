<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvalCategory extends Model
{
    protected $guarded = [];

    public function items()
    {
        $this->hasMany(EvalTemplateItem::class);
    }
}
