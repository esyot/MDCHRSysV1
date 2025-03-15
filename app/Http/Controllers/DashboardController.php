<?php

namespace App\Http\Controllers;

use App\Models\LeaveForm;
use App\Models\Teacher;
use App\Models\TravelForm;
use App\Models\User;
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
        $user = $this->user;

        //Local Variables
        $teacherCount = User::whereHas('teacher')->count();
        $staffCount = User::whereHas('staff')->count();

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
            'user' => $user,
            'roles' => $roles,
            'pageTitle' => 'Dashboard',
            'teacherCount' => $teacherCount,
            'staffCount' => $staffCount,
            'leaveRequestCount' => $leaveRequestCount,
            'travelRequestCount' => $travelRequestCount,
            'userOnLeave' => $userOnLeave,
            'userOnTravel' => $userOnTravel,
            'messageSuccess' => session('success') ?? null,

        ]);
    }
}
