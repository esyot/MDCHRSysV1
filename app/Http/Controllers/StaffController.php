<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function search(Request $request)
    {
        $search_value = $request->search_value;

        $users = User::whereDoesntHave('staff')
            ->where(function ($query) use ($search_value) {
                $query->where('last_name', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('first_name', 'LIKE', '%' . $search_value . '%');
            })
            ->get();



        return response()->json($users);
    }
}
