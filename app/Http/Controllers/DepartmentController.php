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

        $departments = Department::with(['parent', 'userHeads'])->get();

        $departmentList = Department::all();

       

        return inertia('Pages/Department/Department', [
            'roles' => $roles,
            'user' => $user,
            'departments' => $departments,
            'departmentList' =>  $departmentList,
            'parentDepartments' => $parentDepartments,
            'messageSuccess' => session('success') ?? null,
            'pageTitle' => 'Departments'
        ]);
    }

    public function create(Request $request){

        $department = Department::create($request->all());


        if($department){
            return redirect()->back()->with('success', "Department added successfully!");
        }else{
            return redirect()->back()->with('error', "Department error!");
        }

    }

    public function delete($id){

        $department = Department::find($id);

        if($department){
            $department->delete();
            return redirect()->back()->with('success', 'Department deleted successfully!');
        }else{
            return redirect()->back()->with('error', 'Department not found!');
        }
    }
}
