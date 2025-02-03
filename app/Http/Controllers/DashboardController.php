<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Global variables
        $this->globalVariables();
        $roles = $this->roles;

        //Local Variables

        return Inertia::render('Pages/Dashboard/Dashboard', [
            'user' => Auth::user(),
            'roles' => $roles,
            'pageTitle'=> 'Dashboard',
        ]);
    }
}
