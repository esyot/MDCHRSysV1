<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = [];


    public function user()
    {
        $this->hasOne(User::class);
    }
    public function departments()
    {
        return $this->hasMany(Department::class, 'id', 'department_id')
            ->select([
                'id',
                'name',
                'acronym'
            ]);
    }

}
