<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;

    protected $guarded = [];


    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function userHeads()
    {
        return $this->belongsToMany(User::class, 'user_departments', 'department_id', 'user_id')
            ->wherePivot('type', 'head')
            ->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.middle_name'
            ]);
    }
}
