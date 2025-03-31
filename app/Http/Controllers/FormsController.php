<?php

namespace App\Http\Controllers;

use App\Models\LeaveForm;
use App\Models\TravelForm;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use PHPUnit\Framework\Attributes\After;

class FormsController extends Controller
{
    public function index()
    {
        $this->globalVariables();
        $roles = $this->roles;
        $user = $this->user;


        return inertia('Pages/Forms/Tracking/Tracking', [
            'roles' => $roles,
            'user' => $user,
            'forms' => Inertia::defer(function () {
                $this->globalVariables();
                $user = $this->user;
                $code = $this->apiKey;

                $travelForms = TravelForm::where('user_id', $user->id)
                    ->with([
                        'substitutes',
                        'substitutes.user'
                    ])
                    ->orderBy('created_at', 'ASC')
                    ->get();

                $leaveForms = LeaveForm::where('user_id', Auth::user()->id)
                    ->with([
                        'substitutes',
                        'substitutes.user'
                    ])
                    ->orderBy('created_at', 'ASC')
                    ->get();


                foreach ($travelForms as $form)
                {

                    $term_client = new Client();
                    $term_url = 'https://sis.materdeicollege.com/api/hr/terms';

                    $response = $term_client->get($term_url, [
                        'query' => [
                            'code' => $code,
                        ],
                        'verify' => false
                    ]);

                    $terms = json_decode($response->getBody(), true);

                    $term = collect($terms)->firstWhere('id', $form->term_id);

                    $form['term'] = $term;

                    foreach ($form->substitutes as $substitute)
                    {

                        $subject_id = $substitute->subject_id;
                        $subj_url = 'https://sis.materdeicollege.com/api/hr/subject-classes';
                        $subj_client = new Client();
                        $response = $subj_client->get($subj_url, [
                            'query' => [
                                'code' => $code,
                                'term_id' => $form->term_id,
                                'teacher_id' => $user->teacher->id,
                            ],
                            'verify' => false,
                        ]);

                        $subjects = json_decode($response->getBody(), true);

                        $subject = collect($subjects)->firstWhere('id', $subject_id);

                        $substitute['subject'] = $subject;
                    }
                }




                foreach ($leaveForms as $form)
                {

                    $term_client = new Client();
                    $term_url = 'https://sis.materdeicollege.com/api/hr/terms';

                    $response = $term_client->get($term_url, [
                        'query' => [
                            'code' => $code,
                        ],
                        'verify' => false
                    ]);

                    $terms = json_decode($response->getBody(), true);

                    $term = collect($terms)->firstWhere('id', $form->term_id);

                    $form['term'] = $term;

                    foreach ($form->substitutes as $substitute)
                    {

                        $subject_id = $substitute->subject_id;
                        $subj_url = 'https://sis.materdeicollege.com/api/hr/subject-classes';
                        $subj_client = new Client();
                        $response = $subj_client->get($subj_url, [
                            'query' => [
                                'code' => $code,
                                'term_id' => $form->term_id,
                                'teacher_id' => $user->teacher->id,
                            ],
                            'verify' => false,
                        ]);

                        $subjects = json_decode($response->getBody(), true);

                        $subject = collect($subjects)->firstWhere('id', $subject_id);


                        $substitute['subject'] = $subject;
                    }
                }


                $travelForms->transform(function ($form) use ($user) {
                    $form->first_name = $user->first_name;
                    $form->last_name = $user->last_name;
                    $form->middle_name = $user->middle_name;
                    return $form;
                });


                $forms = [];
                $forms['Travel Form'] = $travelForms;
                $forms['Leave Form'] = $leaveForms;


                $flattenedForms = [];
                foreach ($forms as $formType => $formArray)
                {
                    foreach ($formArray as $form)
                    {
                        $form['form_type'] = $formType;
                        $flattenedForms[] = $form;
                    }
                }

                usort($flattenedForms, function ($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });


                return $flattenedForms;
            }),
            'pageTitle' => 'Track Forms'
        ]);
    }

    public function checking($action = null)
    {

        $this->globalVariables();
        $roles = $this->roles;
        $user = $this->user;
        $code = $this->apiKey;



        $notificationsController = new NotificationController();
        $notificationsController->read($user->id, 'checking');


        return inertia('Pages/Forms/Checking/Checking', [
            'user' => $user,
            'pageTitle' => 'Checking',
            'selected' => $action ?? 'all',
            'forms' => Inertia::defer(function () {

                $this->globalVariables();
                $user = $this->user;
                $code = $this->apiKey;

                $travelForms = [];
                $leaveForms = [];

                if ($user->role('dean'))
                {
                    $userDepartmentId = $user->teacher->department_id;

                    $userIds = User::whereRelation('teacher', 'department_id', '=', $userDepartmentId)
                        ->pluck('id');

                    $leaveForms = LeaveForm::where('status', 'pending')
                        ->whereIn('user_id', $userIds)
                        ->with([
                            'substitutes.user',
                            'substitutes.user.teacher',
                            'user',
                            'user.staff',
                            'user.teacher',
                            'endorser',
                            'userJobDetail',

                        ])->orderBy('created_at', 'ASC')->get();

                    $travelForms = TravelForm::where('status', 'pending')
                        ->orderBy('created_at', 'ASC')
                        ->with([
                            'substitutes.user',
                            'substitutes.user.teacher',
                            'user',
                            'user.staff',
                            'user.teacher',
                            'endorser',
                            'userJobDetail',

                        ])->orderBy('created_at', 'ASC')->get();

                    $leaveForms = $leaveForms->merge($leaveForms);
                    $travelForms = $travelForms->merge($travelForms);


                } else if ($user->role('hr'))
                {

                    $leaveForms = LeaveForm::where('status', 'dean_approved')
                        ->with([
                            'substitutes.user',
                            'substitutes.user.teacher',
                            'user',
                            'user.staff',
                            'user.teacher',
                            'recommender',
                            'userJobDetail',

                        ])->orderBy('created_at', 'ASC')->get();

                    $travelForms = TravelForm::where('status', 'dean_approved')

                        ->orderBy('created_at', 'ASC')
                        ->with([
                            'substitutes.user',
                            'substitutes.user.teacher',
                            'user',
                            'user.staff',
                            'user.teacher',
                            'recommender',
                            'userJobDetail',

                        ])->orderBy('created_at', 'ASC')->get();


                    $leaveForms = $leaveForms->merge($leaveForms);
                    $travelForms = $travelForms->merge($travelForms);

                } else if ($user->role('vp-admin'))
                {

                    $leaveForms = LeaveForm::where('status', 'hr_approved')
                        ->with([
                            'substitutes.user',
                            'substitutes.user.teacher',
                            'user',
                            'user.staff',
                            'user.teacher',
                            'endorser',
                            'userJobDetail',
                        ])->orderBy('created_at', 'ASC')->get();

                    $travelForms = TravelForm::where('status', 'hr_approved')
                        ->orderBy('created_at', 'ASC')
                        ->with([
                            'substitutes.user',
                            'substitutes.user.teacher',
                            'user',
                            'user.staff',
                            'user.teacher',
                            'endorser',
                            'userJobDetail',
                        ])->orderBy('created_at', 'ASC')->get();

                    $leaveForms = $leaveForms->merge($leaveForms);
                    $travelForms = $travelForms->merge($travelForms);



                } else if ($user->role('vp-acad'))
                {


                    $leaveForms = LeaveForm::where('status', 'vp_admin_approved')
                        ->with([
                            'substitutes.user',
                            'substitutes.user.teacher',
                            'user',
                            'user.staff',
                            'user.teacher',
                            'endorser',
                            'userJobDetail',

                        ])->orderBy('created_at', 'ASC')->get();

                    $travelForms = TravelForm::where('status', 'vp_admin_approved')
                        ->orderBy('created_at', 'ASC')
                        ->with([
                            'substitutes.user',
                            'substitutes.user.teacher',
                            'user',
                            'user.staff',
                            'user.teacher',
                            'endorser',
                            'userJobDetail',

                        ])->orderBy('created_at', 'ASC')->get();

                    $leaveForms = $leaveForms->merge($leaveForms);
                    $travelForms = $travelForms->merge($travelForms);

                } else if ($user->role('p-admin'))
                {
                    $leaveForms = LeaveForm::where('status', 'vp_acad_approved')
                        ->with([
                            'substitutes.user',
                            'substitutes.user.teacher',

                            'user',
                            'user.staff',
                            'user.teacher',
                            'endorser',
                            'userJobDetail',

                        ])->orderBy('created_at', 'ASC')->get();


                    $travelForms = TravelForm::where('status', 'vp_acad_approved')
                        ->orderBy('created_at', 'ASC')
                        ->with([
                            'substitutes.user',
                            'substitutes.user.teacher',
                            'user',
                            'user.staff',
                            'user.teacher',
                            'endorser',
                            'userJobDetail',

                        ])->orderBy('created_at', 'ASC')->get();

                    $leaveForms = $leaveForms->merge($leaveForms);
                    $travelForms = $travelForms->merge($travelForms);

                } else
                {
                    return back()->withErrors([
                        'error' => "Sorry, you are not allowed to do this action."
                    ]);
                }



                foreach ($leaveForms as $form)
                {

                    foreach ($form->substitutes as $substitute)
                    {


                        $subject_id = $substitute->subject_id;
                        $subj_url = 'https://sis.materdeicollege.com/api/hr/subject-classes';
                        $subj_client = new Client();
                        $response = $subj_client->get($subj_url, [
                            'query' => [
                                'code' => $code,
                                'term_id' => $form->term_id,
                                'teacher_id' => $form->user->teacher->id,
                            ],
                            'verify' => false,
                        ]);

                        $subjects = json_decode($response->getBody(), true);

                        $subject = collect($subjects)->firstWhere('id', $subject_id);


                        $substitute['subject'] = $subject;



                    }
                }

                foreach ($travelForms as $form)
                {

                    foreach ($form->substitutes as $substitute)
                    {


                        $subject_id = $substitute->subject_id;
                        $subj_url = 'https://sis.materdeicollege.com/api/hr/subject-classes';
                        $subj_client = new Client();
                        $response = $subj_client->get($subj_url, [
                            'query' => [
                                'code' => $code,
                                'term_id' => $form->term_id,
                                'teacher_id' => $form->user->teacher->id,
                            ],
                            'verify' => false,
                        ]);

                        $subjects = json_decode($response->getBody(), true);

                        $subject = collect($subjects)->firstWhere('id', $subject_id);


                        $substitute['subject'] = $subject;



                    }
                }


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

                return $flattenedForms;
            }),
            'roles' => $roles,
            'success' => session('success') ?? null,
        ]);

    }

    public function forward(Request $request)
    {
        $this->globalVariables();
        $user = $this->user;

        $notificationController = new NotificationController();


        if ($request->action == 'dean_approved')
        {
            if ($request->form_type === 'Leave Form')
            {
                LeaveForm::find($request->id)
                    ->update([
                        'status' => $request->action,
                        'recommended_by' => Auth::user()->id,
                    ]);

                $notificationController->create(
                    'Leave Form',
                    $user->last_name . ', ' . $user->first_name . ' forwarded a leave application, check it now.',
                    'checking',
                    'hr',
                    '/forms/checking'
                );
            } elseif ($request->form_type === 'Travel Form')
            {
                TravelForm::where('id', $request->id)
                    ->where('user_id', $request->user_id)
                    ->update([
                        'status' => $request->action,
                        'recommended_by' => Auth::user()->id,
                    ]);

                $notificationController->create(
                    'Travel Form',
                    $user->last_name . ', ' . $user->first_name . ' forwarded a travel form, check it now for approval.',
                    'checking',
                    'hr',
                    '/forms/checking'
                );
            }
        } elseif ($request->action == 'hr_approved')
        {
            if ($request->form_type == 'Leave Form')
            {
                LeaveForm::find($request->id)
                    ->update([
                        'status' => $request->action,
                        'endorsed_by' => Auth::user()->id,
                    ]);

                $notificationController->create(
                    'Leave Form',
                    $user->last_name . ', ' . $user->first_name . ' forwarded a leave application, check it now for approval.',
                    'checking',
                    'vp-admin',
                    '/forms/checking'
                );
            } elseif ($request->form_type == 'Travel Form')
            {
                TravelForm::where('id', $request->id)
                    ->where('user_id', $request->user_id)
                    ->update([
                        'status' => $request->action,
                        'endorsed_by' => Auth::user()->id,
                    ]);

                $notificationController->create(
                    'Travel Form',
                    $user->last_name . ', ' . $user->first_name . ' forwarded a travel application, check it now for approval.',
                    'checking',
                    'vp-admin',
                    '/forms/checking'
                );
            }
        } elseif ($request->action == 'vp_admin_approved')
        {
            if ($request->form_type == 'Leave Form')
            {
                LeaveForm::find($request->id)
                    ->update([
                        'days_with_pay' => $request->days_with_pay ?? 0,
                        'days_without_pay' => $request->days_without_pay ?? 0,
                        'status' => $request->action,
                    ]);

                $notificationController->create(
                    'Leave Form',
                    $user->last_name . ', ' . $user->first_name . ' forwarded a leave application, check it now for approval.',
                    'checking',
                    'vp-acad',
                    '/forms/checking'
                );
            } elseif ($request->form_type == 'Travel Form')
            {
                TravelForm::where('id', $request->id)
                    ->where('user_id', $request->user_id)
                    ->update([
                        'status' => $request->action,
                    ]);

                $notificationController->create(
                    'Travel Form',
                    $user->last_name . ', ' . $user->first_name . ' forwarded a travel application, check it now for approval.',
                    'checking',
                    'vp-acad',
                    '/forms/checking'
                );
            }
        } elseif ($request->action == 'vp_acad_approved')
        {
            if ($request->form_type == 'Leave Form')
            {
                LeaveForm::find($request->id)
                    ->update([
                        'status' => $request->action,
                    ]);

                $notificationController->create(
                    'Leave Form',
                    $user->last_name . ', ' . $user->first_name . ' forwarded a leave application, check it now for approval.',
                    'checking',
                    'p-admin',
                    '/forms/checking'
                );
            } elseif ($request->form_type == 'Travel Form')
            {
                TravelForm::where('id', $request->id)
                    ->where('user_id', $request->user_id)
                    ->update([
                        'status' => $request->action,
                    ]);

                $notificationController->create(
                    'Travel Form',
                    $user->last_name . ', ' . $user->first_name . ' forwarded a travel application, check it now for approval.',
                    'checking',
                    'p-admin',
                    '/forms/checking'
                );
            }
        } elseif ($request->action == 'p_admin_approved')
        {
            if ($request->form_type == 'Leave Form')
            {
                LeaveForm::find($request->id)
                    ->update([
                        'status' => 'approved',
                    ]);

                $userId = LeaveForm::where('id', $request->id)->first()->user_id;

                $notificationController->create(
                    'Leave Form',
                    $user->last_name . ', ' . $user->first_name . ' approved your leave application, check it now.',
                    'tracking',
                    $userId,
                    '/forms/tracking'
                );
            } elseif ($request->form_type == 'Travel Form')
            {
                TravelForm::where('id', $request->id)
                    ->where('user_id', $request->user_id)
                    ->update([
                        'status' => 'approved',
                    ]);

                $userId = TravelForm::where('id', $request->id)->first()->user_id;

                $notificationController->create(
                    'Travel Form',
                    $user->last_name . ', ' . $user->first_name . ' approved your travel application, check it now.',
                    'tracking',
                    $userId,
                    '/forms/tracking'
                );
            }
        } else
        {
            if ($request->form_type == 'Leave Form')
            {
                LeaveForm::find($request->id)
                    ->update([
                        'status' => 'declined',
                        'disapproved_by' => Auth::user()->id,
                        'disapproval_description' => $request->disapproval_description,
                    ]);

                $userId = LeaveForm::where('id', $request->id)->first()->user_id;

                $notificationController->create(
                    'Leave Form',
                    $user->last_name . ', ' . $user->first_name . ' has declined your leave application. Please check the details now.',
                    'tracking',
                    $userId,
                    '/forms/tracking'
                );

            }

            if ($request->form_type == 'Travel Form')
            {
                TravelForm::find($request->id)
                    ->update([
                        'status' => 'declined',
                        'disapproved_by' => Auth::user()->id,
                        'disapproval_description' => $request->disapproval_description,
                    ]);

                $userId = TravelForm::where('id', $request->id)->first()->user_id;

                $message = $user->last_name . ', ' . $user->first_name . ' has declined your travel application. Please check the details now. with a message ' . "'" . $request->disapproval_description . "'.";

                $notificationController->create(
                    'Travel Form',
                    $message,
                    'tracking',
                    $userId,
                    '/forms/tracking'
                );

            }
        }

        return redirect()->back()->with([
            'success' => 'Form submitted successfully!',
        ]);
    }

    public function find($form_type, $user_id, $year)
    {
        $forms = [];

        if ($form_type === 'Leave Form')
        {
            $forms = LeaveForm::whereYear('date_start', $year)
                ->where('user_id', $user_id)
                ->where('status', 'approved')
                ->select([
                    'id',
                    'user_id',
                    'leave_type',
                    'date_start',
                    'date_end',
                    'created_at',
                    'status',
                ])->get() ?? null;
        } else if ($form_type === 'Travel Form')
        {
            $forms = TravelForm::whereYear('date_start', $year)
                ->where('user_id', $user_id)
                ->where('status', 'approved')
                ->select([
                    'id',
                    'user_id',
                    'date_start',
                    'date_end',
                    'semister',
                    'created_at',
                    'status',
                ])->get() ?? null;
        } else
        {
            return response()->json(['message' => 'Invalid form type'], 400);
        }

        return response()->json($forms);
    }

    public function delete($type, $id)
    {
        if ($type == 'Leave Form')
        {
            LeaveForm::find($id)->delete();
        } else if ($type == 'Travel Form')
        {
            TravelForm::find($id)->delete();
        }

        return redirect()->back()->with([
            'success' => 'Form deleted successfully!'
        ]);
    }

    public function editMode($id, $type)
    {
        $this->globalVariables();
        $user = $this->user;
        $roles = $this->roles;

        $code = config('variables.api_key');

        $url = 'https://sis.materdeicollege.com/api/hr/terms';

        $client = new Client();

        $response = $client->get($url, [
            'query' => [
                'code' => $code,
            ],
            'verify' => false,
        ]);

        $terms = json_decode($response->getBody(), true);

        $annuals = array_filter($terms, function ($item) {
            return $item['type'] === 'sem';
        });

        $terms = array_values($annuals);

        usort($terms, function ($a, $b) {
            return strtotime($b['start']) - strtotime($a['start']);
        });

        $users = User::whereNot('id', Auth::user()->id)
            ->orderBy('last_name')
            ->get([
                'id',
                'first_name',
                'last_name'
            ]);

        if ($type === 'Leave Form')
        {

            $formData = LeaveForm::where('id', $id)->with([
                'substitutes.user',
                'substitutes.user.teacher',
            ])->first();

            foreach ($formData->substitutes as $sub)
            {
                $teacher = $sub->user->last_name . ', ' . $sub->user->first_name;
                $sub['teacher'] = $teacher;

                $sub['days'] = explode(', ', $sub['days']);
            }

            return inertia('Pages/Forms/LeaveForm/LeaveForm', [
                'formDataToEdit' => $formData,
                'user' => $user,
                'roles' => $roles,
                'users' => $users,
                'terms' => $terms,
                'api_key' => $code,

            ]);

        } elseif ($type === 'Travel Form')
        {
            $formData = TravelForm::where('id', $id)->with([
                'substitutes.user',
                'substitutes.user.teacher',
            ])->first();

            $budgetTypes = config('variables.budgetTypes');
            $budgetCharges = config('variables.budgetCharges');

            foreach ($formData->substitutes as $sub)
            {
                $teacher = $sub->user->last_name . ', ' . $sub->user->first_name;
                $sub['teacher'] = $teacher;

                $sub['days'] = explode(', ', $sub['days']);
            }




            return inertia('Pages/Forms/TravelForm/TravelForm', [
                'formDataToEdit' => $formData,
                'user' => $user,
                'roles' => $roles,
                'users' => $users,
                'budgetTypes' => $budgetTypes,
                'budgetCharges' => $budgetCharges,
                'terms' => $terms,
                'api_key' => $code,


            ]);
        }

    }
}
