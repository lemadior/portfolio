<?php

namespace App\Services\Resources\Api\V1\Admin\Faux;

class CoursesService
{
    /**
     * Prepare data for Admin Faux Courses resource request from API
     *
     * @param mixed $resource
     *
     * @return array
     */
    public function getCoursesData(mixed $resource): array
    {
        $courses = $resource ?? [];

        $coursesData = [];

        foreach ($courses as $course) {
            $coursesData[] = [
                'id' => $course->id,
                'name' => $course->name,
                'description' => $course->description
            ];
        }

        return [
            'courses' => $coursesData
        ];
    }
}
