<?php

namespace App\Http\Controllers\Faux;

use App\Services\Faux\StudentsByCourseService;
use App\Http\Requests\Faux\StudentsRequest;
use App\Http\Controllers\Controller;

class StudentsController extends Controller
{
    /**
     * @var StudentsByCourseService $service
     */
    protected StudentsByCourseService $service;

    public function __construct()
    {
        $this->service = new StudentsByCourseService();
    }

    /**
     * Show students filtered by course name
     *
     * @param StudentsRequest $request
     */
    public function showFilteredStudents(StudentsRequest $request)
    {
        $studentsData = $this->service->getStudentData($request);

        return view('faux.students', compact('studentsData'));
    }
}
