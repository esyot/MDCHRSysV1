<?php

namespace App\Http\Controllers;

use App\Models\PersonalDetail;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

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

        } else if ($request->isNotFilled([['first_name', 'last_name', 'middle_name']]) || $request->hasAny([['first_name', 'last_name', 'middle_name']])) {

            $user->update($request->only([
                'first_name',
                'last_name',
                'middle_name'
            ]));
            $user_personal_details = PersonalDetail::where('user_id', Auth::user()->id)->first();
            $user_personal_details->update($request->except(['first_name', 'last_name', 'middle_name']));
        }

        return redirect()->back()->with('success', 'Personal details updated successfully!');
    }
}
