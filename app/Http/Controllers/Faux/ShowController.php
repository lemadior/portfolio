<?php

namespace App\Http\Controllers\Faux;

use App\Http\Controllers\Controller;
use App\Models\Faux\Student;

class ShowController extends Controller
{
    /**
     * Just show data about specified student (with group and subscribed courses)
     *
     * @param Student $student
     */
    public function showStudentData(Student $student)
    {
        return view('faux.show', compact('student'));
    }
}
