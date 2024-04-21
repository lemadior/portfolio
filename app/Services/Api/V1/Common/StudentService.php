<?php

namespace App\Services\Api\V1\Common;

use App\Models\Faux\Student;

class StudentService
{
    /**
     * Prepare data for Faux Students resource request from API
     *
     * @param Student $student
     *
     * @return array
     */
    public function getStudentCoursesData(Student $student): array
    {
        $courses = $student->courses;

        $courseNames = [];

        foreach ($courses as $course) {
            $courseNames[] = $course->name;
        }

        return $courseNames;
    }
}
