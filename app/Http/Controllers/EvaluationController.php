<?php

namespace App\Http\Controllers;

use App\Models\EvalTemplate;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class EvaluationController extends Controller
{


    public function evaluationManager($id = null)
    {


        $this->globalVariables();

        $roles = $this->roles;
        $user = $this->user;
        if (!$id)
        {

            $templates = EvalTemplate::orderBy('created_at', 'ASC')->get();

            return inertia('Pages/Admin/EvaluationManager/EvaluationManager', [
                'templates' => $templates,
                'roles' => $roles,
                'user' => $user,
                'pageTitle' => 'Evaluation Manager',
                'messageSuccess' => session('success') ?? null,
            ]);
        } else
        {

            $template = EvalTemplate::find($id);


            return inertia('Pages/Admin/EvaluationManager/EvaluationView', [
                'template' => $template,
                'roles' => $roles,
                'user' => $user,
                'pageTitle' => 'Evaluation Manager',
                'messageSuccess' => session('success') ?? null,
            ]);

        }

    }

    public function createTemplate(Request $request)
    {

        if (!$request->template_id)
        {
            $template = EvalTemplate::create($request->toArray());

            if ($template)
            {
                return redirect()->back()->with('success', 'A new template has been added successfully!');
            } else
            {
                return redirect()->back()->with('error', 'Template creation failed!');

            }
        } else
        {
            $template = EvalTemplate::create($request->toArray());

            if ($template)
            {
                return redirect()->back()->with('success', 'A new template has been added successfully!');
            } else
            {
                return redirect()->back()->with('error', 'Template creation failed!');

            }
        }



    }

    public function view()
    {
        $this->globalVariables();

        $roles = $this->roles;
        $user = $this->user;

        return inertia('Pages/Admin/EvaluationManager/EvaluationView', [
            'roles' => $roles,
            'user' => $user,
            'pageTitle' => 'Evaluation View'
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

            $code = config('variables.api_key');

            $url = 'https://sis.materdeicollege.com/api/hr/terms';

            $client = new Client();

            $response = $client->get($url, [
                'query' => [
                    'code' => $code,
                ],
                'verify' => false,
            ]);

            $terms = json_decode($response->getBody(), true);

            usort($terms, fn($a, $b) => strcmp($b['start'], $a['start']) ?: strcmp($b['end'], $a['end']));


            return inertia('Pages/Forms/Evaluation/TeacherEvaluation', [
                'user' => $user,
                'terms' => $terms,
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
