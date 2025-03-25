<?php

namespace App\Http\Controllers;
use App\Models\LeaveForm;
use App\Models\TravelForm;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index(Request $request)
    {

        $this->globalVariables();
        $roles = $this->roles;
        $user = $this->user;

        $personalDetails = User::with([
            'personalDetails',
            'personalDetails.permanentAddress',
            'personalDetails.residentialAddress',
            'userJobDetails',
            'userFamilies',
            'userEducationalBackgrounds',
            'userProfessionalExaminations',
            'userAwardReceives',
            'userAdminPosHelds',
            'userWorkExperiences',
            'userStudies',
            'userParticipations',
            'userSpecialTrainings',
            'userOtherInfos',
            'userSchoolCurriculars',
            'userOtherDetails',
            'userReferences',
            'userReferences.address',
            'userValidIds',


        ])
            ->where('users.id', Auth::user()->id)
            ->first();

        $personalLeaves = LeaveForm::where('leave_type', 'Personal')
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        $sickLeaves = LeaveForm::where('leave_type', 'Sick')
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        $travelDays = TravelForm::where('user_id', $user->id)
            ->where('status', 'approved')
            ->get();

        $travelForms = $travelDays->pluck('amount');

        $amountRequested = $travelForms->sum();

        $totalTravel = 0;

        foreach ($travelDays as $day)
        {
            $dateStart = Carbon::parse($day->date_start);
            $dateEnd = Carbon::parse($day->date_end);

            $calculatedDaysFromTo = $dateEnd->diffInDays($dateStart);

            $totalTravel += $calculatedDaysFromTo;
        }


        $overview = [
            'amount' => $amountRequested,
            'personalLeaves' => $personalLeaves,
            'sickLeaves' => $sickLeaves,
            'traveledDays' => $totalTravel,
        ];


        $auth = Session::get('authenticate');

        if ($auth == true)
        {
            $auth = true;

        } else if ($auth == null)
        {

            $auth = false;
        }


        return Inertia::render('Pages/Account/Account', [
            'user' => $user,
            'roles' => $roles,
            'auth' => $auth,
            'personalDetails' => $personalDetails,
            'success' => session('success') ?? null,
            'pageTitle' => 'Account',
            'overviewData' => $overview,
            'tab' => $request->tab ?? "overview",
            'isDefaultPass' => $request->is_default_pass * 1 ?? 0,
        ]);
    }

    public function accountFeatureUpdate(Request $request)
    {

        $user = Auth::user();

        $user->update([
            'is_update_with_email' => $request->is_update_with_email == 'on' ? 1 : 0,
            'is_two_step_verification' => $request->is_two_step_verification == 'on' ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Account settings updated successfully!');
    }

}
