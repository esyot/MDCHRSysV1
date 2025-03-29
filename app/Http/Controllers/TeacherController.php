<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function search($search_value)
    {

        $searchTerms = preg_split('/[\s,]+/', $search_value);

        $teachers = User::where(function ($query) use ($searchTerms) {
            foreach ($searchTerms as $term)
            {
                $query->orWhere(DB::raw('LOWER(first_name)'), 'LIKE', '%' . strtolower($term) . '%')
                    ->orWhere(DB::raw('LOWER(last_name)'), 'LIKE', '%' . strtolower($term) . '%')
                    ->orWhere(DB::raw('LOWER(middle_name)'), 'LIKE', '%' . strtolower($term) . '%');
            }
        })
            ->whereHas('teacher', function ($query) {
                $query->whereNotNull('id');
            })
            ->where('id', '!=', Auth::user()->id)
            ->get();


        return response()->json($teachers);
    }

}

