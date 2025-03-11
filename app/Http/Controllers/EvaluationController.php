<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{


    public function index()
    {

        $this->globalVariables();

        $roles = $this->roles;
        $user = $this->user;

        $templates = [];

        return inertia('Pages/Admin/EvaluationManager/EvaluationManager', [
            'templates' => $templates,
            'roles' => $roles,
            'user' => $user,
            'pageTitle' => 'Evaluation Manager'
        ]);
    }

    public function create($id, Request $request)
    {
        $questions = [];
        $comments = [];

        foreach ($request->formData as $key => $value)
        {

            if (strpos($key, 'q') === 0)
            {
                preg_match('/q(\d+)/', $key, $matches);
                $questionNumber = $matches[1];


                $questions[$questionNumber][] = $value;
            } elseif (strpos($key, 'c') === 0)
            {
                preg_match('/c(\d+)/', $key, $matches);
                $commentNumber = $matches[1];


                $comments[$commentNumber][] = $value;
            }
        }
        $questionsText = "[" . implode("], [", array_map(function ($item) {
            return implode(",", $item);
        }, $questions)) . "]";

        $commentsText = "[" . implode("], [", array_map(function ($item) {
            return implode(",", $item);
        }, array: $comments)) . "]";



        $evaluation = Evaluation::create([
            'questions' => $questionsText,
            'comments' => $commentsText,
            'ratings' => $request->ratings,
            'date_time' => Carbon::now(),
            'user_id' => $id,
            'conducted_by' => Auth::user()->id,
        ]);

        return redirect()->route('user.view', $id)->with('success', 'Evaluation form submitted successfully!');
    }

    public function evaluate($id, $type)
    {
        if ($type === 'teacher')
        {
            $user = User::findOrFail($id);
            return inertia('Pages/Forms/Evaluation/TeacherEvaluation', [
                'user' => $user,
            ]);
        } elseif ($type === 'staff')
        {
            $user = User::findOrFail($id);
            return inertia('Pages/Forms/Evaluation/StaffEvaluation', [
                'user' => $user,
            ]);
        }

    }


}
