<?php

namespace App\Http\Controllers;

use App\Http\Requests\TravelFormRequest;
use App\Models\Substitute;
use App\Models\TravelForm;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


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

        $budgetTypes = config('variables.budgetTypes');
        $budgetCharges = config('variables.budgetCharges');




        return Inertia::render('Pages/Forms/TravelForm/TravelForm', [
            'user' => $user,
            'roles' => $roles,
            'personalDetails' => $personalDetails->toArray(),
            'budgetTypes' => $budgetTypes,
            'budgetCharges' => $budgetCharges,
            'formData' => $request ?? null,
            'pageTitle' => 'Travel Form',
            'formDataToEdit' => null,
            'terms' => Inertia::defer(function () {
                $client = new Client();
                $response = $client->get('https://sis.materdeicollege.com/api/hr/terms', [
                    'query' => ['code' => config('variables.api_key')],
                    'verify' => false,
                ]);

                $terms = json_decode($response->getBody(), true);
                $terms = array_values(array_filter($terms, fn($item) => $item['type'] === 'sem'));
                usort($terms, fn($a, $b) => strtotime($b['start']) - strtotime($a['start']));

                return $terms;
            }),
        ]);
    }


    public function submit(TravelFormRequest $request)
    {
        $this->globalVariables();
        $name = $this->name;
        $formData = $request->toArray();

        if (!isset($formData['form_id']))
        {
            $formData['user_id'] = Auth::user()->id;

            unset($formData['substitutes']);
            unset($formData['form_id']);
            unset($formData['class_description']);

            $travelForm = TravelForm::create($formData);

            if ($request->substitutes)
            {

                $substitutes = json_decode($request->substitutes, true);



                foreach ($substitutes as $sub)
                {

                    $sub['travel_form_id'] = $travelForm->id;

                    unset($sub['teacher']);

                    $days = isset($sub['days']) && is_array($sub['days']) ? implode(', ', $sub['days']) : '';

                    $sub['days'] = $days;


                    Substitute::create($sub);
                }

            } else
            {
                $travelForm->update([
                    'class_description' => $request->class_description,
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
            $form_id = $formData['form_id'];

            unset($formData['form_id']);
            unset($formData['class_description']);
            unset($formData['substitutes']);


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
                    'class_description' => $request->class_description,
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
