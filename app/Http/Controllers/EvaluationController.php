<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\EvalTemplate;
use App\Models\EvalTemplateCategory;
use App\Models\EvalTemplateItem;
use App\Models\Evaluation;
use App\Models\Teacher;
use App\Models\User;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class EvaluationController extends Controller
{

    public function updateTemplateItem(Request $request)
    {

        $item = EvalTemplateItem::find($request->item_id);

        $item->update([
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Item updated successfully!');
    }

    public function deletTemplateItem($id)
    {

        $item = EvalTemplateItem::find($id);

        $item->delete();

        return redirect()->back()->with('success', 'Item deleted successfully!');
    }


    public function userView($id)
    {
        $this->globalVariables();

        $user = $this->user;
        $roles = $this->roles;

        $fetchedUser = User::where('id', $id)
            ->with('teacher', 'teacher.department', 'staff')
            ->first();

        $userRoles = $fetchedUser->getRoleNames();

        $evaluations = Evaluation::where('teacher_id', $fetchedUser->id)
            ->with([
                'evaluator',
                'evalTemplate',
            ])
            ->get();

        $code = config('variables.api_key');


        foreach ($evaluations as $evaluation)
        {

            try
            {
                $subj_url = 'https://sis.materdeicollege.com/api/hr/subject-classes';
                $subj_client = new Client();
                $response = $subj_client->get($subj_url, [
                    'query' => [
                        'code' => $code,
                        'term_id' => $evaluation->term_id,
                        'teacher_id' => $fetchedUser->teacher->id,
                    ],
                    'verify' => false,
                ]);

                $subjects = json_decode($response->getBody(), true);

            } catch (ConnectException $e)
            {

                return back()->withErrors([
                    'error' => 'Unable to connect to the server. Please check the domain or your internet connection.'
                ]);
            } catch (RequestException $e)
            {

                if ($e->getCode() === 0)
                {
                    return back()->withErrors([
                        'error' => 'No Internet Connection!'
                    ]);
                } else
                {
                    return back()->withErrors([
                        'error' => 'Error fetching data from the server!'
                    ]);
                }
            }


            $subject = collect($subjects)->firstWhere('id', $evaluation->subject_id);
            $evaluation['subject'] = $subject;

            $eval_template_category_items = EvalTemplateCategory::where('eval_template_id', $evaluation->eval_template_id)
                ->with('items')
                ->get();

            $total_descriptions_count = 0;

            foreach ($eval_template_category_items as $category)
            {
                $total_descriptions_count += $category->items->whereNotNull('description')->count();
            }

            $evaluation['maxPoints'] = $total_descriptions_count * 5;
        }

        try
        {
            $hr_url = 'https://sis.materdeicollege.com/api/hr/terms';
            $client = new Client();
            $response = $client->get($hr_url, [
                'query' => [
                    'code' => $code,
                ],
                'verify' => false,
            ]);

            $terms = json_decode($response->getBody(), true);

        } catch (ConnectException $e)
        {

            return back()->withErrors([
                'error' => 'Unable to connect to the server. Please check the domain or your internet connection.'
            ]);
        } catch (RequestException $e)
        {

            if ($e->getCode() === 0)
            {
                return back()->withErrors([
                    'error' => 'No Internet Connection!'
                ]);
            } else
            {
                return back()->withErrors([
                    'error' => 'Error fetching data from the server!'
                ]);
            }
        }

        $annuals = array_filter($terms, function ($item) {
            return $item['type'] === 'annual';
        });

        $currentDate = Carbon::now();

        $currentTerm = collect($terms)->first(function ($term) use ($currentDate) {
            $termStart = Carbon::parse($term['start']);
            $termEnd = Carbon::parse($term['end']);
            return $currentDate->between($termStart, $termEnd);
        });
        $currentTerm = $currentTerm['id'];

        $terms = array_map(function ($row) {
            $row['start'] = Carbon::parse($row['start'])->format('Y');
            $row['end'] = Carbon::parse($row['end'])->format('Y');
            return $row;
        }, $annuals);

        usort($terms, fn($a, $b) => strcmp($b['start'], $a['start']) ?: strcmp($b['end'], $a['end']));

        return inertia('Pages/Evaluation/UserView', [
            'user' => $user,
            'userRoles' => $userRoles,
            'personalDetails' => $fetchedUser,
            'roles' => $roles,
            'pageTitle' => $fetchedUser->last_name . ', ' . $fetchedUser->first_name,
            'user_id' => $id,
            'messageSuccess' => session('success') ?? null,
            'terms' => $terms,
            'evaluations' => $evaluations,
            'currentTerm' => $currentTerm,
            'api_key' => config('variable.api_key'),
        ]);
    }
    public function userList($type, Request $request)
    {
        $this->globalVariables();
        $roles = $this->roles;
        $user = $this->user;

        $searchValue = $request->searchValue;
        $orderBy = $request->orderBy ?? "ASC";

        if ($type === 'teacher')
        {
            $users = User::when($request->searchValue, function ($query, $searchValue) {
                $query->where('last_name', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('first_name', 'LIKE', '%' . $searchValue . '%');
            })
                ->whereNot('id', $user->id)
                ->whereRelation('teacher', 'department_id', '=', $user->teacher->department_id)
                ->role(['teacher'])
                ->orderBy('last_name', $orderBy)
                ->paginate(12);

            $department = Department::find(Teacher::where('id', $user->id)
                ->pluck('department_id')->first());

            return inertia('Pages/Evaluation/UserList', [
                'user' => $user,
                'type' => $type,
                'searchValue' => $searchValue,
                'orderBy' => $orderBy,
                'users' => $users,
                'department' => $department,
                'roles' => $roles,
                'pageTitle' => "Teacher's Evaluation",

            ]);

        } else
        {
            $users = User::when($request->searchValue, function ($query, $searchValue) {
                $query->where('last_name', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('first_name', 'LIKE', '%' . $searchValue . '%');
            })
                ->whereHas('staff')
                ->role('staff')
                ->orderBy('last_name', $orderBy)
                ->paginate(12);


            $department = null;

            return inertia('Pages/Evaluation/UserList', [
                'user' => $user,
                'type' => $type,
                'searchValue' => $searchValue,
                'users' => $users,
                'department' => $department,
                'roles' => $roles,
                'pageTitle' => "Staff's Evaluation",
            ]);
        }
    }
    public function evaluationManager($id = null)
    {
        $this->globalVariables();

        $roles = $this->roles;
        $user = $this->user;
        if (!$id)
        {

            $templates = EvalTemplate::orderBy('created_at', 'ASC')->get();

            return inertia('Pages/EvaluationManager/EvaluationTemplateManager', [
                'templates' => $templates,
                'roles' => $roles,
                'user' => $user,
                'pageTitle' => 'Evaluation Manager',
                'successMessage' => session('success') ?? null,
            ]);
        } else
        {

            $template = EvalTemplate::find($id);

            $categories = EvalTemplateCategory::where('eval_template_id', $id)->with([
                'items'
            ])->get();


            return inertia('Pages/EvaluationManager/EvaluationTemplateView', [
                'template' => $template,
                'categories' => $categories,
                'roles' => $roles,
                'user' => $user,
                'pageTitle' => 'Evaluation Manager',
                'successMessage' => session('success') ?? null,
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

            $categories = EvalTemplateCategory::where('eval_template_id', $request->template_id)->get();

            $template = EvalTemplate::create([
                'name' => $request->name,
                'for' => $request->for,
                'type' => $request->type ?? null,
            ]);

            foreach ($categories as $category)
            {

                $newCategory = EvalTemplateCategory::create([
                    'eval_template_id' => $template->id,
                    'title' => $category->title,
                ]);


                $items = EvalTemplateItem::where('eval_template_category_id', $category->id)->get();


                foreach ($items as $item)
                {
                    EvalTemplateItem::create([
                        'eval_template_category_id' => $newCategory->id,
                        'description' => $item->description,
                    ]);
                }
            }


            if ($template)
            {
                return redirect()->back()->with('success', 'A new template has been added successfully!');
            } else
            {
                return redirect()->back()->with('error', 'Template creation failed!');

            }
        }

    }

    public function deleteTemplate($id)
    {
        if ($id)
        {
            $template = EvalTemplate::where('id', $id)->first();

            $template->delete();

            if ($template)
            {
                return redirect()->back()->with('success', 'Template deleted successfully!');
            }
        } else
        {
            return redirect()->back()->with('error', 'Template not found!');

        }
    }

    public function addCategory(Request $request)
    {
        $category = $request->category;

        EvalTemplateCategory::create([
            'eval_template_id' => $category['template_id'],
            'title' => $category['title'],

        ]);

    }

    public function addItem(Request $request)
    {
        $item = $request->item;

        EvalTemplateItem::create([
            'eval_template_category_id' => $item['category_id'],
            'description' => $item['description'],
        ]);
    }

    public function toggleEvaluationTemplate($id, $type)
    {

        $template = EvalTemplate::where('id', $id)->first();

        if ($template && $type === 'teacher')
        {
            EvalTemplate::
                where('type', $template->type)
                ->where('for', 'teacher')
                ->update([
                    'is_open' => 0,
                ]);

            $template->update([
                'is_open' => $template->is_open === 1 ? 0 : 1,
            ]);


        } else if ($template && $type === 'staff')
        {
            EvalTemplate::where('for', 'staff')
                ->update([
                    'is_open' => 0,
                ]);

            $template->update([
                'is_open' => $template->is_open === 1 ? 0 : 1,
            ]);
        }
        return redirect()->back();
    }


    public function view()
    {
        $this->globalVariables();

        $roles = $this->roles;
        $user = $this->user;

        return inertia('Pages/EvaluationManager/EvaluationView', [
            'roles' => $roles,
            'user' => $user,
            'pageTitle' => 'Evaluation View'
        ]);
    }

    public function submitEvaluation(Request $request)
    {

        if ($request->type === 'teacher')
        {

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

            $term = collect($terms)->where('id', $request->term_id)->first();

            $selectedTerm = $term;

            $semester = null;
            foreach ($terms as $term)
            {
                if ($term['id'] == $request->term_id)
                {
                    $semester = $term;
                    break;
                }
            }

            if (!$semester)
            {
                return response()->json(['message' => 'Semester not found.'], 404);
            }

            $academicYear = null;
            foreach ($terms as $term)
            {
                if ($term['type'] == 'annual')
                {

                    $semesterStart = Carbon::parse($semester['start']);
                    $semesterEnd = Carbon::parse($semester['end']);
                    $academicYearStart = Carbon::parse($term['start']);
                    $academicYearEnd = Carbon::parse($term['end']);

                    if ($semesterStart >= $academicYearStart && $semesterEnd <= $academicYearEnd)
                    {
                        $academicYear = $term;
                        break;
                    }
                }
            }

            $semister = "";

            if (strpos($selectedTerm['name'], "1st") !== false)
            {
                $semister = 'first';
            } else if (strpos($selectedTerm['name'], "2nd") !== false)
            {
                $semister = "second";
            }

            $evaluation = Evaluation::create([
                'teacher_id' => $request->user_id,
                'eval_template_id' => $request->template_id,
                'term_id' => $request->term_id,
                'acad_term_id' => $academicYear['id'],
                'subject_id' => $request->subject_id,
                'evaluator_id' => Auth::user()->id,
                'semister' => $semister,
                'overall_points' => $request->overallPoints,
                'overall_mean' => $request->overallMean,
                'ratings' => $request->ratings,
                'comments' => $request->comments,
            ]);

            if ($evaluation)
            {
                return redirect()->back()->with([
                    'success' => 'Evaluation submitted successfully!'
                ]);
            } else
            {
                return back()->withErrors([
                    'error' => 'Evaluation failed!'
                ]);
            }

        }

        if ($request->type === 'staff')
        {

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

            $term = collect($terms)->where('id', $request->term_id)->first();

            $selectedTerm = $term;

            $semester = null;
            foreach ($terms as $term)
            {
                if ($term['id'] == $request->term_id)
                {
                    $semester = $term;
                    break;
                }
            }

            if (!$semester)
            {
                return response()->json(['message' => 'Semester not found.'], 404);
            }

            $academicYear = null;
            foreach ($terms as $term)
            {
                if ($term['type'] == 'annual')
                {

                    $semesterStart = Carbon::parse($semester['start']);
                    $semesterEnd = Carbon::parse($semester['end']);
                    $academicYearStart = Carbon::parse($term['start']);
                    $academicYearEnd = Carbon::parse($term['end']);

                    if ($semesterStart >= $academicYearStart && $semesterEnd <= $academicYearEnd)
                    {
                        $academicYear = $term;
                        break;
                    }
                }
            }

            $semister = "";

            if (strpos($selectedTerm['name'], "1st") !== false)
            {
                $semister = 'first';
            } else if (strpos($selectedTerm['name'], "2nd") !== false)
            {
                $semister = "second";
            }
            $evaluation = Evaluation::create([
                'teacher_id' => $request->user_id,
                'eval_template_id' => $request->template_id,
                'term_id' => $request->term_id,
                'acad_term_id' => $academicYear['id'],
                'evaluator_id' => Auth::user()->id,
                'semister' => $semister,
                'overall_points' => $request->overallPoints,
                'overall_mean' => $request->overallMean,
                'ratings' => $request->ratings,
                'comments' => $request->comments,

            ]);


            if ($evaluation)
            {
                return redirect()->back()->with([
                    'success' => 'Evaluation subiited successfully!'
                ]);
            } else
            {
                return back()->withErrors([
                    'error' => 'Evaluation failed!'
                ]);
            }
        }

    }

    public function evaluateUser($type, $user_id)
    {
        if ($type === 'teaching' || $type === 'work')
        {

            $user = User::where('id', $user_id)
                ->with('teacher')
                ->first();

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



            $annuals = array_filter($terms, function ($item) {
                return $item['type'] === 'sem' && strpos($item['name'], 'Summer') === false;
            });

            $terms = array_values($annuals);

            usort($terms, fn($a, $b) => strcmp($b['start'], $a['start']) ?: strcmp($b['end'], $a['end']));


            $template = EvalTemplate::where('for', 'teacher')
                ->where('is_open', 1)
                ->where('type', $type)
                ->first();

            $evalCategories = EvalTemplateCategory::where('eval_template_id', $template->id)->with([
                'items'
            ])->get()->toArray();

            $api_key = config('variables.api_key');

            $evaluations = Evaluation::where('teacher_id', $user_id)->get();


            return inertia('Pages/Evaluation/TeacherEvaluation', [
                'template_id' => $template->id,
                'user' => $user,
                'terms' => $terms,
                'evalCategories' => $evalCategories,
                'template' => $template,
                'api_key' => $api_key,
                'evaluations' => $evaluations,
                'success' => session('success') ?? null,

            ]);


        } elseif ($type === 'staff')
        {


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



            $annuals = array_filter($terms, function ($item) {
                return $item['type'] === 'sem' && strpos($item['name'], 'Summer') === false;
            });

            $terms = array_values($annuals);

            usort($terms, fn($a, $b) => strcmp($b['start'], $a['start']) ?: strcmp($b['end'], $a['end']));



            $user = User::where('id', $user_id)
                ->with('staff')
                ->first();

            $template = EvalTemplate::where('for', 'staff')
                ->where('is_open', 1)
                ->first();

            $evalCategories = EvalTemplateCategory::where('eval_template_id', $template->id)->with([
                'items'
            ])->get()->toArray();

            $api_key = config('variables.api_key');


            return inertia('Pages/Evaluation/StaffEvaluation', [
                'terms' => $terms,
                'template_id' => $template->id,
                'user' => $user,
                'evalCategories' => $evalCategories,

            ]);

        }

    }

}
