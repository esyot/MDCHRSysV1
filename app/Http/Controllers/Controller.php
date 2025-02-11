<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected $roles;

    protected $user;


    protected function globalVariables()
    {

        $this->roles = Auth::user()->getRoleNames();

        $this->user = User::find(Auth::user()->id)->makeHidden([
            'user',
            'password',
        ]);
    }
}
