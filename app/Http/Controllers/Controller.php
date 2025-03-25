<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class Controller
{
    protected $roles;

    protected $user;

    protected $departments;

    protected $departmentList;

    protected $parentDepartments;

    protected $roleList;



    protected function globalVariables()
    {

        $this->roles = Auth::user()->getRoleNames();

        $this->roleList = Role::all()->pluck('name');

        $this->user = User::where('id', Auth::user()->id)
            ->with([
                'teacher',
                'teacher.department',
                'staff'
            ])->first();


        $this->departmentList = Department::all();
    }
}
