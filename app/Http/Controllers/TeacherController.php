<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function search($search_value)
    {

        $teachers = User::
            whereHas('teacher', function ($query) {
                $query->where('id', '!=', null);
            })
            ->where(function ($query) use ($search_value) {
                $query->where('first_name', 'LIKE', '%' . $search_value . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search_value . '%');
            })
            ->whereNot('id', Auth::user()->id)
            ->get();

        return response()->json($teachers);

    }
}

