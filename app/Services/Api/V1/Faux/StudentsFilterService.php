<?php

namespace App\Services\Api\V1\Faux;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Faux\Course;

class StudentsFilterService
{
    /**
     * Prepare data for Faux Students resource request from API
     *
     * @param Course $course
     * @param int $perPage
     *
     * @return Collection | LengthAwarePaginator
     */
    public function getStudentsData(Course $course, int $perPage): Collection | LengthAwarePaginator
    {
        $students = $course->students()->with('group');

        return $perPage ? $students->paginate($perPage) : $students->get();
    }
}
