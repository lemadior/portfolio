<?php

namespace App\Services\Api\V1\Admin\Faux;

use App\Models\Faux\Student;

class DeleteService
{
    /**
     * Proceed for Admin Faux student delete request from API
     *
     * @param Student $student
     *
     * @return int
     */
    public function deleteStudent(Student $student): int
    {
        $studentId = $student->id;

        $student->delete();

        return $studentId;
    }
}
