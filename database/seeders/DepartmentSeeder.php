<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $departments = [
            ['acronym' => 'ELEM', 'name' => 'Elementary Department', 'parent_id' => null],
            ['acronym' => 'PRE-K', 'name' => 'Preschool Department', 'parent_id' => null],
            ['acronym' => 'HS', 'name' => 'High School Department', 'parent_id' => null],
            ['acronym' => 'JHS', 'name' => 'Junior High School', 'parent_id' => null],
            ['acronym' => 'SHS', 'name' => 'Senior High School', 'parent_id' => null],
            ['acronym' => 'College', 'name' => 'College Department', 'parent_id' => null],
            ['acronym' => 'CABM', 'name' => 'College of Accountancy, Business & Management', 'parent_id' => null],
            ['acronym' => 'CABM-B', 'name' => 'Business Department', 'parent_id' => null],
            ['acronym' => 'CABM-H', 'name' => 'Hospitality Department', 'parent_id' => null],
            ['acronym' => 'CAST', 'name' => 'College of Arts, Sciences, & Technology', 'parent_id' => null],
            ['acronym' => 'CCJ', 'name' => 'College of Criminal Justice', 'parent_id' => null],
            ['acronym' => 'COE', 'name' => 'College of Education', 'parent_id' => null],
            ['acronym' => 'CON', 'name' => 'College of Nursing', 'parent_id' => null],
            ['acronym' => 'GS', 'name' => 'Graduate Studies', 'parent_id' => null],
        ];

        $insertedDepartments = [];
        foreach ($departments as &$department) {
            $insertedDepartments[] = Department::create([
                'acronym' => $department['acronym'],
                'name' => $department['name'],
                'parent_id' => null,  
            ]);
        }
        $insertedDepartments[1]->update(['parent_id' => $insertedDepartments[0]->id]); 
        $insertedDepartments[3]->update(['parent_id' => $insertedDepartments[2]->id]); 
        $insertedDepartments[4]->update(['parent_id' => $insertedDepartments[2]->id]); 
        $insertedDepartments[6]->update(['parent_id' => $insertedDepartments[5]->id]); 
        $insertedDepartments[7]->update(['parent_id' => $insertedDepartments[6]->id]); 
        $insertedDepartments[8]->update(['parent_id' => $insertedDepartments[6]->id]); 
        $insertedDepartments[9]->update(['parent_id' => $insertedDepartments[5]->id]); 
        $insertedDepartments[10]->update(['parent_id' => $insertedDepartments[5]->id]); 
        $insertedDepartments[11]->update(['parent_id' => $insertedDepartments[5]->id]); 
        $insertedDepartments[12]->update(['parent_id' => $insertedDepartments[5]->id]); 
    }
}
