<?php

namespace App\Http\Controllers\Admin\Faux;

use App\Http\Controllers\Controller;
use App\Models\Faux\Student;
use App\Models\Faux\Course;
use App\Models\Faux\Group;

class EditController extends Controller
{
    public function edit(Student $student)
    {
        $courses = Course::all();

        $groups = $student->group_id ? null : $groups = Group::all();

        $studentCourses = $student->courses->pluck('name')->toArray();

        return view('admin.faux.edit', compact('student', 'courses', 'studentCourses', 'groups'));
    }
}
