<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {

        $this->globalVariables();
        $roles = $this->roles;

        $personalDetails = User::with([
            'personalDetails',
            'personalDetails.permanentAddress',
            'personalDetails.residentialAddress',
            'userJobDetails',

        ])
            ->where('users.id', Auth::user()->id)
            ->first();

        return Inertia::render('Pages/Account/account', [
            'user' => Auth::user(),
            'roles' => $roles,
            'personalDetails' => $personalDetails,
            'messageSuccess' => session('success') ?? null,
        ]);
    }
}
