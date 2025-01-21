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

        if ($request->isMethod('post') && $request->all() == []) {
            return redirect()->back()->with('error', 'No changes to update.');
        }

        $user = User::find(Auth::user()->id);

        $fieldsToCheck = ['first_name', 'last_name', 'middle_name'];

        if ($request->only($fieldsToCheck) == $request->all()) {

            $user->update($request->only($fieldsToCheck));
        } else if (
            $request->isNotFilled([['first_name', 'last_name', 'middle_name']])
            || $request->hasAny([['first_name', 'last_name', 'middle_name']])
        ) {

            $user->update($request->only([
                'first_name',
                'last_name',
                'middle_name'
            ]));

            $user_personal_details = PersonalDetail::where('user_id', Auth::user()->id)->first();
            $user_personal_details->update($request->except(['first_name', 'last_name', 'middle_name']));

            $residential_address_id = $user_personal_details->residential_address_id;
            $permanent_address_id = $user_personal_details->permanent_address_id;

            $residential_address = Address::where('id', $residential_address_id);
            $permanent_address = Address::where('id', $permanent_address_id);

            $residentialAddressData = [];
            $permanentAddressData = [];

            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'residential_address.') === 0 && $value) {
                    $residentialAddressData[str_replace('residential_address.', '', $key)] = $value;
                }
            }


            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'permanent_address.') === 0 && $value) {
                    $permanentAddressData[str_replace('permanent_address.', '', $key)] = $value;
                }
            }


            if ($residentialAddressData) {
                $residential_address->update($residentialAddressData);
            }

            if ($permanentAddressData) {
                $permanent_address->update($permanentAddressData);
            }
        }

        return redirect()->back()->with('success', 'Personal details updated successfully!');
    }
}
