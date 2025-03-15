<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {

        $this->globalVariables();
        $user = $this->user;
        $roles = $this->roles;

        $developers = @config('variables.developers');

        return inertia('Pages/Others/About', [
            'user' => $user,
            'roles' => $roles,
            'pageTitle' => "About",
            'developers' => $developers
        ]);
    }
}
