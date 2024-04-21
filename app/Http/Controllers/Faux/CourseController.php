<?php

namespace App\Http\Controllers\Faux;

use App\Http\Requests\Faux\CourseRequest;
use App\Http\Controllers\Controller;
use App\Models\Faux\Course;

class CourseController extends Controller
{
    /**
     * Show course data with students subscribed to this course
     *
     * @param CourseRequest $request
     * @param Course $course
     */
    public function showCourseData(CourseRequest $request, Course $course)
    {
        $data = $request->validated();

        $studentsPerPage = $data['per_page'] ?? 10;

        $students = $course->students()->paginate($studentsPerPage);

        return view('faux.course', compact('course', 'students', 'studentsPerPage'));
    }
}
