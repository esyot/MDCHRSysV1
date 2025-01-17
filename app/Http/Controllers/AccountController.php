<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {

        // Global variables
        $this->globalVariables();
        $roles = $this->roles;

        $personalDetails = User::join('personal_details', 'users.id', '=', 'personal_details.user_id')
            ->join('addresses', 'personal_details.permanent_address_id', '=', 'addresses.id')
            ->select(
                'users.id as id',
                'users.first_name as first_name',
                'users.last_name as last_name',
                'users.middle_name as middle_name',
                'addresses.house_no as house_no',
                'addresses.street as street',
                'addresses.subdv as subdv',
                'addresses.brgy as brgy',
                'addresses.municipality as municipality',
                'addresses.province as province',
                'addresses.zip_code as zip_code'
            )
            ->where('users.id', Auth::user()->id)
            ->first();




        return Inertia::render('Pages/Account/account', [
            'user' => Auth::user(),
            'roles' => $roles,
            'personalDetails' => $personalDetails->toArray()
        ]);
    }
}
