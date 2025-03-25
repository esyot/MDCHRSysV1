<?php

namespace App\Http\Controllers;

use App\Models\Substitute;
use App\Models\TravelForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TravelFormController extends Controller
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

        ])
            ->where('users.id', Auth::user()->id)
            ->first();

        $users = User::whereNot('id', $user->id)->select([
            'id',
            'first_name',
            'middle_name',
            'last_name'
        ])->get();


        $budgetTypes = config('variables.budgetTypes');
        $budgetCharges = config('variables.budgetCharges');

        return inertia('Pages/Forms/TravelForm/TravelForm', [
            'user' => $user,
            'users' => $users,
            'roles' => $roles,
            'personalDetails' => $personalDetails->toArray(),
            'budgetTypes' => $budgetTypes,
            'budgetCharges' => $budgetCharges,
            'formData' => $request ?? null,
            'pageTitle' => 'Travel Form',
            'formDataToEdit' => null

        ]);
    }


    public function submit(Request $request)
    {
        $name = Auth::user()->last_name . ', ' . Auth::user()->first_name;

        if (!$request->formData['form_id'])
        {
            $formData = $request->formData;

            $formData['user_id'] = Auth::user()->id;

            unset($formData['form_id']);
            unset($formData['class_description']);

            $travelForm = TravelForm::create($formData);

            if ($request->substitutes)
            {

                $substitutes = $request->substitutes;

                foreach ($substitutes as $sub)
                {

                    $sub['travel_form_id'] = $travelForm->id;

                    unset($sub['days']);
                    unset($sub['teacher']);

                    $days = isset($sub['days']) && is_array($sub['days']) ? implode(', ', $sub['days']) : '';

                    $sub['days'] = $days;

                    Substitute::create($sub);
                }

            } else
            {
                $travelForm->update([
                    'class_description' => $request->formData['class_description'],
                ]);
            }

            if ($travelForm)
            {

                $notificationController = new NotificationController;

                $notificationController->create(
                    'Travel Form',
                    $name . ' filed a travel form, please check it now!',
                    'checking',
                    'dean',
                    '/forms/checking'
                );

                return redirect()->route('forms.tracking')->with('success', 'Travel request submitted successfully!.');
            } else
            {
                return redirect()->back()->with('error', 'Travel request submission failed!.');
            }

        } else
        {
            $form_id = $request->formData['form_id'];

            $formData = $request->formData;

            unset($formData['form_id']);
            unset($formData['class_description']);

            $travelForm = TravelForm::find($form_id);

            if ($travelForm)
            {
                $travelForm->update($formData);
            }

            Substitute::where('travel_form_id', $form_id)->delete();

            if ($request->substitutes)
            {

                $array = $request->substitutes;

                $substitutes = json_decode($array, true);

                foreach ($substitutes as $sub)
                {

                    $sub['travel_form_id'] = $form_id;


                    unset($sub['teacher']);
                    unset($sub['user']);

                    $sub['days'] = implode(', ', $sub['days']);

                    Substitute::create($sub);
                }

            } else
            {
                $travelForm->update([
                    'class_description' => $request->formData['class_description'],
                ]);
            }


            if ($travelForm)
            {

                $travelForm->update([
                    'status' => 'pending',
                    'disapproved_by' => '',
                    'endorsed_by' => '',
                    'recommended_by' => '',

                ]);

                $notificationController = new NotificationController;

                $notificationController->create(
                    'Travel Form',
                    $name . ' re-submits a travel form, please check it now!',
                    'checking',
                    'dean',
                    '/forms/checking'
                );


                return redirect()->route('forms.tracking')->with('success', 'Travel request submitted successfully!.');
            } else
            {
                return redirect()->back()->with('error', 'Travel request submission failed!.');
            }
        }
    }

}
