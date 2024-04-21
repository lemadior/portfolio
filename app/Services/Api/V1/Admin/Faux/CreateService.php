<?php

namespace App\Services\Api\V1\Admin\Faux;

use App\Models\Faux\Student;

class CreateService
{
    /**
     * Proceed for Admin Faux Student Creation request from API
     *
     * @param array $requestData
     *
     * @return Student
     */
    public function createNewStudent(array $requestData): Student
    {
        $courseIds = $requestData['course_ids'];;

        $studentData['group_id'] = $requestData['group_id'];
        $studentData['first_name'] = $requestData['first_name'];
        $studentData['last_name'] = $requestData['last_name'];

        $student = Student::firstOrCreate($studentData);

        $student->courses()->attach($courseIds);

        return $student;
    }
}
