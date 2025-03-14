<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function userUpdateRole($id, Request $request)
    {
        $user = User::find($id);

        $user->syncRoles([]);


        if ($request->roles && !empty($request->roles))
        {
            $user->assignRole($request->roles);

            $roleExist = Role::where('name', 'dean')->whereIn('id', $request->roles)->exists();
        }

        return redirect()->back()->with('success', 'Roles updated successfully!');
    }
}
