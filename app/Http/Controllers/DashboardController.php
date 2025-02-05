<?php

namespace App\Http\Controllers;

use App\Models\LeaveForm;
use App\Models\TravelForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        $userCount = User::all()->count();

        $leaveRequestCount = LeaveForm::where('status', 'pending')->get()->count();
        $travelRequestCount = TravelForm::where('status', 'pending')->get()->count();

        $userOnLeave = LeaveForm::where('date_end', '>', Carbon::today())
        ->where('status', 'approved')
        ->get()
        ->count();

        $userOnTravel = TravelForm::where('date_end', '>', Carbon::today())
        ->where('status', 'approved')
        ->get()
        ->count();

        return Inertia::render('Pages/Dashboard/Dashboard', [
            'user' => Auth::user(),
            'roles' => $roles,
            'pageTitle'=> 'Dashboard',
            'userCount' =>  $userCount,
            'leaveRequestCount' => $leaveRequestCount,
            'travelRequestCount' => $travelRequestCount,
            'userOnLeave' => $userOnLeave,
            'userOnTravel'=>  $userOnTravel

        ]);
    }
}
