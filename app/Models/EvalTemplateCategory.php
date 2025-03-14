<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvalTemplateCategory extends Model
{
    protected $guarded = [];

    public function items()
    {

        return $this->hasMany(EvalTemplateItem::class);
    }
}
