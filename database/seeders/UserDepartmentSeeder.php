<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $departmentsWithParent = DB::table('departments as t1')
            ->leftJoin('departments as t2', 't1.parent_id', '=', 't2.id')
            ->leftJoin('departments as t3', 't2.parent_id', '=', 't3.id')
            ->leftJoin('departments as t4', 't3.parent_id', '=', 't4.id')
            ->select(
                't1.id as department_id',
                't1.acronym as acronym',
                't1.name as department_name',
                DB::raw('COALESCE(t4.acronym, t3.acronym, t2.acronym, t1.acronym) as parent')
            )
            ->whereNotNull('t1.parent_id')
            ->get();
    
        $departmentsWithNoParent = DB::table('departments as t1')
            ->leftJoin('departments as t2', 't1.id', '=', 't2.parent_id')
            ->select(
                't1.id as department_id',
                't1.acronym as acronym',
                't1.name as department_name',
                't1.acronym as parent'
            )
            ->whereNull('t1.parent_id')
            ->whereNull('t2.id')
            ->get();
    
       
        $departments = $departmentsWithNoParent->concat($departmentsWithParent);
       
        $department_ids = $departments->pluck('department_id');
    
        $users = User::all();
        
        foreach ($users as $user) {
            UserDepartment::create([
                'user_id' => $user->id,
                'department_id' => $department_ids->random(),
            ]);
        }
    
    }
}
