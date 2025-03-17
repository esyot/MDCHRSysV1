<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $this->globalVariables();
        $roles = $this->roles;
        $user = $this->user;
        $parentDepartments = $this->parentDepartments;

        $departments = Department::with(['parent'])->get();

        $departmentList = Department::all();



        return inertia('Pages/Department/Department', [
            'roles' => $roles,
            'user' => $user,
            'departments' => $departments,
            'departmentList' => $departmentList,
            'parentDepartments' => $parentDepartments,
            'messageSuccess' => session('success') ?? null,
            'pageTitle' => 'Departments'
        ]);
    }

    public function syncDepartments()
    {



    }
}
