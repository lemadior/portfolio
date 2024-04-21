<?php

namespace App\Services\Api\V1\Common;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Faux\Course;

class CourseService
{
    /**
     * Prepare data for Faux Courses resource request from API
     *
     * @param Course $course
     * @param int $perPage
     *
     * @return Collection | LengthAwarePaginator
     */
    public function getCourseData(Course $course, int $perPage): Collection | LengthAwarePaginator
    {
        return $perPage
            ? $course->students()->with('group')->paginate($perPage)
            : $course->students()->with('group')->get();
    }
}
