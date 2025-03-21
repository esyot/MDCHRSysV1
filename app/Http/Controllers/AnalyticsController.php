<?php

namespace App\Http\Controllers;

use App\Models\LeaveForm;
use App\Models\TravelForm;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {

        $this->globalVariables();
        $user = $this->user;
        $roles = $this->roles;

        $leaveForms = LeaveForm::where('status', 'approved')
            ->with([
                'substitutes.user',
                'user',
                'endorser',
                'userJobDetail',

            ])->orderBy('created_at', 'ASC')->get();


        $travelForms = TravelForm::where('status', 'approved')
            ->orderBy('created_at', 'ASC')
            ->with([
                'substitutes.user',
                'user',
                'endorser',
                'userJobDetail',

            ])->orderBy('created_at', 'ASC')->get();


        $forms = [];
        $forms['Travel Form'] = $travelForms;
        $forms['Leave Form'] = $leaveForms;


        $flattenedForms = [];
        foreach ($forms as $formType => $formArray)
        {
            foreach ($formArray as $form)
            {
                $form['form_type'] = $formType;

                $form['endorser'] = $form['endorser'] ? $form['endorser']->toArray() : null;
                $form['user_job_detail'] = $form['user_job_detail'] ? $form['user_job_detail']->toArray() : null;

                $flattenedForms[] = $form;
            }
        }

        usort($flattenedForms, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        $illness = LeaveForm::where('status', "approved")->pluck('illness');


        return inertia('Pages/Admin/Analytics', [
            'user' => $user,
            'roles' => $roles,
            'pageTitle' => "Analytics",
            'forms' => $flattenedForms,
            'illness' => $illness,
        ]);
    }
}
