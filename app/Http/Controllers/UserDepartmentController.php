<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Http\Request;

class UserDepartmentController extends Controller
{
    public function userUpdateDepartment($id, Request $request ){

        $userRoles = User::find($id)->getRoleNames();

        if($request->departments){
           UserDepartment::where('user_id', $id)->delete();

           foreach($request->departments as $dept_id){
           UserDepartment::create([
                'user_id'=> $id,
                'department_id' => $dept_id,
                'type'=> $userRoles->contains('dean') ? 'head': 'member'
            ]);
           }
           
        }

        return redirect()->back()->with('success', "User's department has been updated successfully!");
        
    }
}
