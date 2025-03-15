<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\EvalItem;
use App\Models\EvalTemplate;
use App\Models\EvalTemplateCategory;
use App\Models\EvalTemplateItem;
use App\Models\Evaluation;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class EvaluationController extends Controller
{
    public function userView($id)
    {
        $this->globalVariables();

        $user = $this->user;
        $roles = $this->roles;

        $fetchedUser = User::where('id', $id)
            ->with('teacher', 'teacher.department', 'staff')
            ->first();

        $userRoles = $fetchedUser->getRoleNames();

        $evaluations = Evaluation::where('teacher_id', $fetchedUser->id)->get();

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




        return inertia('Pages/Evaluation/UserView', [
            'user' => $user,
            'userRoles' => $userRoles,
            'personalDetails' => $fetchedUser,
            'roles' => $roles,
            'pageTitle' => $fetchedUser->last_name . ', ' . $fetchedUser->first_name,
            'user_id' => $id,
            'messageSuccess' => session('success') ?? null,
            'terms' => $terms,
            'evaluations' => $evaluations
        ]);
    }
    public function userList($type)
    {
        $this->globalVariables();
        $roles = $this->roles;
        $user = $this->user;

        if ($type === 'teacher')
        {
            $users = User::whereNot('id', $user->id)
                ->whereIn('id', function ($query) use ($user) {
                    $query->select('user_id')
                        ->from('teachers')
                        ->where('department_id', Teacher::where('id', $user->id)->pluck('department_id')->first());
                })
                ->paginate(12);

            $allUsers = User::whereNot('id', $user->id)
                ->whereIn('id', function ($query) use ($user) {
                    $query->select('user_id')
                        ->from('teachers')
                        ->where('department_id', Teacher::where('id', $user->id)->pluck('department_id')->first());
                })
                ->get();

            $department = Department::find(Teacher::where('id', $user->id)
                ->pluck('department_id')->first());

            return inertia('Pages/Evaluation/UserList', [
                'user' => $user,
                'users' => $users,
                'allUsers' => $allUsers,
                'department' => $department,
                'roles' => $roles,
                'pageTitle' => "Teacher's Evaluation",
                'is_evaluation' => true,
            ]);
        } else
        {
            $users = User::whereHas('staff')
                ->paginate(12);


            $allUsers = User::whereHas('staff')
                ->get();

            $department = null;

            return inertia('Pages/Evaluation/UserList', [
                'user' => $user,
                'users' => $users,
                'allUsers' => $allUsers,
                'department' => $department,
                'roles' => $roles,
                'pageTitle' => "Staff's Evaluation",
                'is_evaluation' => true,
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

            return inertia('Pages/Admin/EvaluationManager/EvaluationTemplateManager', [
                'templates' => $templates,
                'roles' => $roles,
                'user' => $user,
                'pageTitle' => 'Evaluation Manager',
                'messageSuccess' => session('success') ?? null,
            ]);
        } else
        {

            $template = EvalTemplate::find($id);

            $categories = EvalTemplateCategory::where('eval_template_id', $id)->with([
                'items'
            ])->get();


            return inertia('Pages/Admin/EvaluationManager/EvaluationTemplateView', [
                'template' => $template,
                'categories' => $categories,
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

            $categories = EvalTemplateCategory::where('eval_template_id', $request->template_id)->get();

            $template = EvalTemplate::create([
                'name' => $request->name,
                'for' => $request->for
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
        $template = EvalTemplate::find($id);

        if ($template && $type === 'teacher')
        {
            EvalTemplate::where('for', 'teacher')
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

    public function submitEvaluation(Request $request)
    {

        $categories = collect($request->ratings)
            ->reduce(function ($cats, $v, $k) {
                if (preg_match('/^c(\d+)_i(\d+)/', $k, $m))
                {
                    $cid = (int) $m[1];
                    $iid = (int) $m[2];

                    $cats[$cid] ??= ['id' => $cid, 'items' => []];
                    $cats[$cid]['items'][] = ['id' => $iid, 'rating' => (int) $v];
                }
                return $cats;
            }, []);

        $categories = array_values($categories);


        $evaluation = Evaluation::create([
            'template_id' => $request->template_id,
            'user_id' => $request->user_id,
            'conducted_by' => Auth::user()->id,
            'ratings' => $request->overallPoints,
            'date_time' => Carbon::now(),

        ]);

        return redirect()->route('evaluations.user-view', $request->id)->with('success', 'Evaluation form submitted successfully!');
    }

    public function evaluate($id, $type)
    {
        if ($type === 'teacher')
        {

            $user = User::where('id', $id)
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

            usort($terms, fn($a, $b) => strcmp($b['start'], $a['start']) ?: strcmp($b['end'], $a['end']));


            $template = EvalTemplate::where('for', 'teacher')
                ->where('is_open', 1)
                ->first();

            $evalCategories = EvalTemplateCategory::where('eval_template_id', $template->id)->with([
                'items'
            ])->get()->toArray();

            $api_key = config('variables.api_key');


            return inertia('Pages/Evaluation/TeacherEvaluation', [
                'template_id' => $template->id,
                'user' => $user,
                'terms' => $terms,
                'evalCategories' => $evalCategories,
                'api_key' => $api_key,

            ]);


        } elseif ($type === 'staff')
        {
            $user = User::findOrFail($id);
            return inertia('Pages/Evaluation/StaffEvaluation', [
                'user' => $user,
            ]);
        }

    }




}
