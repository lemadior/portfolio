<?php

namespace App\Services\Api\V1\Admin\Faux;

use App\Models\Faux\Student;

class EditService
{
    /**
     * Prepare data for Admin Faux Student Edition request from API
     *
     * @param array $requestData
     *
     * @return Student
     */
    public function editStudent(array $requestData): Student
    {
        $student = $requestData['student'];
        $currentCourseIds = $requestData['current_course_ids'];

        $studentData['group_id'] = $requestData['group_id'];
        $studentData['first_name'] = $requestData['first_name'];
        $studentData['last_name'] = $requestData['last_name'];

        $newCourseIds = $requestData['course_ids'] ?? $currentCourseIds;

        $student->update($studentData);

        $student->courses()->sync($newCourseIds);

        $student->refresh();

        return $student;
    }
}
