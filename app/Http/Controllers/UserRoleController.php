<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function userUpdateRole($id, Request $request)
    {
        $user = User::find($id);

        $user->syncRoles([]);

       
        if ($request->roles && !empty($request->roles)) {
            $user->assignRole($request->roles);

            $roleExist = Role::where('name', 'dean')->whereIn('id', $request->roles)->exists();

            if ($roleExist) {
                UserDepartment::where('user_id', $id)->update([
                    'type' => 'head'
                ]);
            } else {
                UserDepartment::where('user_id', $id)->update([
                    'type' => 'member'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Roles updated successfully!');
    }
}
