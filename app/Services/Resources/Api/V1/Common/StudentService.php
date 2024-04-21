<?php

namespace App\Services\Resources\Api\V1\Common;

class StudentService
{
    /**
     * Prepare data for Faux Students resource request from API
     *
     * @param mixed $resource
     *
     * @return array
     */
    public function getStudentData(mixed $resource): array
    {
        $student = $resource['student'];

        $courseNames = $resource['courseNames'];

        return [
            'name' => $student->first_name . " " . $student->last_name,
            'group' => $student->group ? $student->group->name : 'NONE',
            'courses' => $courseNames
        ];
    }
}
