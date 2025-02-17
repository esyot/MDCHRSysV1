<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(){

        $this->globalVariables();
        $roles = $this->roles;
        $user = $this->user;

        return inertia('Pages/Departments', [
            'roles' => $roles,
            'user' => $user
        ]);
    }
}
