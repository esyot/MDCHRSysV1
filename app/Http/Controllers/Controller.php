<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class Controller
{
    protected $roles;

    protected $user;

    protected $departments;

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


        $departmentsWithParent = DB::table('departments as t1')
            ->leftJoin('departments as t2', 't1.parent_id', '=', 't2.id')
            ->leftJoin('departments as t3', 't2.parent_id', '=', 't3.id')
            ->leftJoin('departments as t4', 't3.parent_id', '=', 't4.id')
            ->select(
                't1.id as department_id',
                't1.acronym as acronym',
                't1.name as department_name',
                DB::raw('COALESCE(t4.acronym, t3.acronym, t2.acronym, t1.acronym) as parent')

            )
            ->whereNotNull('t1.parent_id')
            ->get();

        $departmentsWithNoParent = DB::table('departments as t1')
            ->leftJoin('departments as t2', 't1.id', '=', 't2.parent_id')
            ->select(
                't1.id as department_id',
                't1.acronym as acronym',
                't1.name as department_name',
                't1.acronym as parent',
            )
            ->whereNull('t1.parent_id')
            ->whereNull('t2.id')
            ->get();

        $this->parentDepartments = $departmentsWithParent;

        $this->departments = $departmentsWithNoParent->concat($departmentsWithParent);
    }
}
