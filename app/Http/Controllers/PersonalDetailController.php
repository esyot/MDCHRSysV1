<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\PersonalDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalDetailController extends Controller
{
    public function updatePersonalDetails(Request $request)
    {

        dd($request->toArray());
        if ($request->isMethod('post') && $request->all() == []) {
            return redirect()->back()->with('error', 'No changes to update.');
        }

        $user = User::find(Auth::user()->id);

        $fieldsToCheck = ['first_name', 'last_name', 'middle_name'];

        if ($request->only($fieldsToCheck) == $request->all()) {

            $user->update($request->only($fieldsToCheck));
        } else if ($request->isNotFilled([['first_name', 'last_name', 'middle_name']]) || $request->hasAny([['first_name', 'last_name', 'middle_name']])) {

            $user->update($request->only([
                'first_name',
                'last_name',
                'middle_name'
            ]));
            $user_personal_details = PersonalDetail::where('user_id', Auth::user()->id)->first();
            $user_personal_details->update($request->except(['first_name', 'last_name', 'middle_name']));


            $residential_address_id = $user_personal_details->residential_address_id;
            $permanent_address_id = $user_personal_details->permanent_address_id;

            $residential_address = Address::find($residential_address_id);
            $permanent_address = Address::find($permanent_address_id);


            $residential_address->update([
                'house_no' => $request->residential_house_no,
                'street' => $request->residential_street,
                'subdv' => $request->residential_subv,
                'brgy' => $request->residential_brgy,
                'municipality' => $request->residential_municipality,
                'province' => $request->residential_province,
                'zip_code' => $request->residential_zip_code,
            ]);


            $permanent_address->update([
                'house_no' => $request->permanent_house_no,
                'street' => $request->permanent_street,
                'subdv' => $request->permanent_subv,
                'brgy' => $request->permanent_brgy,
                'municipality' => $request->permanent_municipality,
                'province' => $request->permanent_province,
                'zip_code' => $request->permanent_zip_code,
            ]);
        }

        return redirect()->back()->with('success', 'Personal details updated successfully!');
    }
}
