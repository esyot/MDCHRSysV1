<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected $roles;


    protected function globalVariables()
    {

        $this->roles = Auth::user()->getRoleNames();
    }
}
