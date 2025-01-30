<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\PersonalDetail;
use App\Models\User;
use App\Models\UserFamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

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

        $requestData = $request->except('user_families');

        $filteredData = Arr::only($requestData, $fieldsToCheck);

        if ($filteredData == $requestData) {
            $user->update($filteredData);
        } else {

            $isFirstNameFilled = !empty($requestData['first_name'] ?? null);
            $isLastNameFilled = !empty($requestData['last_name'] ?? null);
            $isMiddleNameFilled = !empty($requestData['middle_name'] ?? null);

            if (
                !$isFirstNameFilled && !$isLastNameFilled && !$isMiddleNameFilled ||
                ($isFirstNameFilled || $isLastNameFilled || $isMiddleNameFilled)
            ) {

                $user->update(Arr::only($requestData, ['first_name', 'last_name', 'middle_name']));


                $userPersonalDetails = PersonalDetail::where('user_id', Auth::user()->id)->first();
                $userPersonalDetails->update(Arr::except($requestData, ['first_name', 'last_name', 'middle_name']));

                $residentialAddressId = $userPersonalDetails->residential_address_id;
                $permanentAddressId = $userPersonalDetails->permanent_address_id;

                $residentialAddress = Address::find($residentialAddressId);
                $permanentAddress = Address::find($permanentAddressId);

                $residentialAddressData = [];
                $permanentAddressData = [];


                foreach ($requestData as $key => $value) {
                    if (strpos($key, 'residential_address.') === 0 && $value) {
                        $residentialAddressData[str_replace('residential_address.', '', $key)] = $value;
                    }
                }

                foreach ($requestData as $key => $value) {
                    if (strpos($key, 'permanent_address.') === 0 && $value) {
                        $permanentAddressData[str_replace('permanent_address.', '', $key)] = $value;
                    }
                }

                if ($residentialAddressData) {
                    $residentialAddress->update($residentialAddressData);
                }

                if ($permanentAddressData) {
                    $permanentAddress->update($permanentAddressData);
                }
            }
        }

        if ($request->has('user_families')) {
            foreach ($request->user_families as $family) {
                $userFamily = UserFamily::find($family['id']);

                if ($userFamily) {
                    $userFamily->update($family);
                }
            }
        }

        session()->flash('success', 'Personal details updated successfully!');
        return redirect()->back();

    }
}
