<?php

namespace App\Http\Controllers;

use App\Events\NotificationCreate;
use App\Models\LeaveForm;
use App\Models\Substitute;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class LeaveFormController extends Controller
{
    public function index()
    {

        $this->globalVariables();
        $roles = $this->roles;

        $personalDetails = User::with([
            'personalDetails',
            'personalDetails.permanentAddress',
            'personalDetails.residentialAddress',

        ])
            ->where('users.id', Auth::user()->id)
            ->first();

        $users = User::whereNot('id', Auth::user()->id)
            ->orderBy('last_name')
            ->get([
                'id',
                'first_name',
                'last_name'
            ]);

        return inertia('Pages/Forms/LeaveForm/LeaveForm', [

            'user' => Auth::user(),
            'roles' => $roles,
            'personalDetails' => $personalDetails->toArray(),
            'pageTitle' => 'Leave Form',
            'users' => $users->toArray(),
        ]);
    }

    public function submit(Request $request)
    {
        if (!$request->form_id)
        {
            $formData = $request->toArray();

            unset($formData['medical_certificate']);

            unset($formData['substitutes']);

            unset($formData['form_id']);

            if ($formData['leave_type'] === 'Paternity' || $formData['leave_type'] === 'Maternity')
            {
                unset($formData['leave_type_option']);
                unset($formData['vacation_option']);
                unset($formData['convalescence_place']);
                unset($formData['address']);
                unset($formData['sick_type']);
                unset($formData['illness']);
                unset($formData['description']);
                unset($formData['date_of_confinement']);
                unset($formData['date_of_discharge']);
                unset($formData['medical_certificate']);
            } elseif ($formData['leave_type'] === 'Educational')
            {
                unset($formData['vacation_option']);
                unset($formData['convalescence_place']);
                unset($formData['address']);
                unset($formData['sick_type']);
                unset($formData['illness']);
                unset($formData['description']);
                unset($formData['date_of_confinement']);
                unset($formData['date_of_discharge']);
                unset($formData['medical_certificate']);
            } elseif ($formData['leave_type'] === 'Personal')
            {
                unset($formData['convalescence_place']);
                unset($formData['sick_type']);
                unset($formData['illness']);
                unset($formData['description']);
                unset($formData['date_of_confinement']);
                unset($formData['date_of_discharge']);
                unset($formData['medical_certificate']);
            } elseif ($formData['leave_type'] === 'Sick')
            {
                unset($formData['vacation_option']);
                unset($formData['address']);
                unset($formData['description']);
            }

            $formData['user_id'] = Auth::user()->id;

            $leave_form = LeaveForm::create($formData);

            if ($request->hasFile('medical_certificate'))
            {

                $file = $request->file('medical_certificate');


                $path = 'public/users/medical_certificates';

                if (!Storage::exists($path))
                {
                    Storage::makeDirectory($path, 0775, true);
                }

                if (!$file->isValid())
                {
                    return redirect()->back()->with('error', 'Invalid file uploaded.');
                }

                $extension = $file->getClientOriginalExtension();

                $dateTimeNow = Carbon::now()->format('Y-m-d-H-i-s');
                $fileName = $leave_form->user_id . '-' . $dateTimeNow . '.' . $extension;

                Storage::putFileAs($path, $file, $fileName);

                $leave_form->update([
                    'medical_certificate' => $fileName,
                ]);
            }


            if ($request->substitutes)
            {

                $array = $request->substitutes;

                $substitutes = json_decode($array, true);

                foreach ($substitutes as $sub)
                {

                    $sub['leave_form_id'] = $leave_form->id;

                    unset($sub['teacher']);

                    $sub['days'] = implode(', ', $sub['days']);

                    Substitute::create($sub);

                }

            }

            return redirect()->back()->with('success', 'Leave request submitted successfully!.');

        } else
        {

            $formData = $request->toArray();


            $form_id = $formData['form_id'];

            foreach ($formData as $key => $value)
            {
                if ($value === 'null')
                {
                    unset($formData[$key]);
                }
            }


            unset($formData['medical_certificate']);

            unset($formData['substitutes']);

            unset($formData['substitute']);

            unset($formData['form_id']);

            if ($formData['leave_type'] === 'Paternity' || $formData['leave_type'] === 'Maternity')
            {
                unset($formData['leave_type_option']);
                unset($formData['vacation_option']);
                unset($formData['convalescence_place']);
                unset($formData['address']);
                unset($formData['sick_type']);
                unset($formData['illness']);
                unset($formData['description']);
                unset($formData['date_of_confinement']);
                unset($formData['date_of_discharge']);
                unset($formData['medical_certificate']);
            } elseif ($formData['leave_type'] === 'Educational')
            {
                unset($formData['vacation_option']);
                unset($formData['convalescence_place']);
                unset($formData['address']);
                unset($formData['sick_type']);
                unset($formData['illness']);
                unset($formData['description']);
                unset($formData['date_of_confinement']);
                unset($formData['date_of_discharge']);
                unset($formData['medical_certificate']);
            } elseif ($formData['Personal'])
            {
                unset($formData['convalescence_place']);
                unset($formData['sick_type']);
                unset($formData['illness']);
                unset($formData['description']);
                unset($formData['date_of_confinement']);
                unset($formData['date_of_discharge']);
                unset($formData['medical_certificate']);
            } elseif ($formData['leave_type'] === 'Personal')
            {
                unset($formData['convalescence_place']);
                unset($formData['sick_type']);
                unset($formData['illness']);
                unset($formData['description']);
                unset($formData['date_of_confinement']);
                unset($formData['date_of_discharge']);
                unset($formData['medical_certificate']);
            } elseif ($formData['leave_type'] === 'Sick')
            {
                unset($formData['vacation_option']);
                unset($formData['address']);
                unset($formData['description']);
            }

            $record = LeaveForm::find($form_id);

            if ($record)
            {

                $columns = \Schema::getColumnListing((new LeaveForm)->getTable());
                $columns = array_diff($columns, ['id', 'user_id', 'date_start', 'status', 'date_end', 'created_at', 'updated_at']);

                foreach ($columns as $column)
                {
                    $record->$column = null;
                }

                $record->save();
            }

            $formData['status'] = 'Pending';


            LeaveForm::where('id', $form_id)
                ->first()
                ->update($formData);

            if ($request->hasFile('medical_certificate'))
            {

                $file = $request->file('medical_certificate');


                $path = 'public/users/medical_certificates';

                if (!Storage::exists($path))
                {
                    Storage::makeDirectory($path, 0775, true);
                }

                if (!$file->isValid())
                {
                    return redirect()->back()->with('error', 'Invalid file uploaded.');
                }

                $extension = $file->getClientOriginalExtension();

                $dateTimeNow = Carbon::now()->format('Y-m-d-H-i-s');
                $fileName = $leave_form->user_id . '-' . $dateTimeNow . '.' . $extension;

                Storage::putFileAs($path, $file, $fileName);

                $leave_form->update([
                    'medical_certificate' => $fileName,
                ]);
            }


            if ($request->substitutes)
            {

                Substitute::where('leave_form_id', $form_id)->delete();

                $array = $request->substitutes;

                $substitutes = json_decode($array, true);

                foreach ($substitutes as $sub)
                {

                    $sub['leave_form_id'] = $form_id;

                    unset($sub['teacher']);
                    unset($sub['user']);

                    $sub['days'] = implode(', ', $sub['days']);

                    Substitute::create($sub);

                }

            }

            return redirect()->route('forms.tracking')->with('success', 'Leave request submitted successfully!.');


        }
    }

}
