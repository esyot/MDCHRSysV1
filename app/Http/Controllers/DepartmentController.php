<?php

namespace App\Http\Controllers;

use App\Models\Department;
use GuzzleHttp\Client;

class DepartmentController extends Controller
{
    public function index()
    {
        $this->globalVariables();
        $roles = $this->roles;
        $user = $this->user;
        $parentDepartments = $this->parentDepartments;

        $departments = Department::with(['parent'])->get();

        $departmentList = Department::all();

        return inertia('Pages/Department/Department', [
            'roles' => $roles,
            'user' => $user,
            'departments' => $departments,
            'departmentList' => $departmentList,
            'parentDepartments' => $parentDepartments,
            'success' => session('success') ?? null,
            'pageTitle' => 'Departments'
        ]);
    }

    public function syncDepartments()
    {

        $url = 'https://sis.materdeicollege.com/api/hr/departments';

        $api_key = config('variables.api_key');

        $client = new Client();

        $response = $client->get($url, [
            'query' => [
                'code' => $api_key,
            ],

            'verify' => false,
        ]);


        $departments = json_decode($response->getBody()->getContents(), true);

        foreach ($departments as $department)
        {
            $exist = Department::find($department['id']);

            if ($exist)
            {
                $exist->update([
                    'acronym' => $department['accronym'],
                    'name' => $department['name'],
                    'parent_id' => $department['parent_id'],
                ]);

                continue;
            } else
            {
                Department::Create([
                    'id' => $department['id'],
                    'acronym' => $department['accronym'],
                    'name' => $department['name'],
                    'parent_id' => $department['parent_id'],
                ]);
            }

        }

        return redirect()->back()->with('success', 'Departments Synced Successfully');
    }
}
