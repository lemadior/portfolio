<?php

namespace App\Services\Faux;

use App\Http\Requests\Faux\StudentsRequest;
use App\Models\Faux\Student;
use Illuminate\Http\Request;
use App\Models\Faux\Course;

class StudentsByCourseService
{
    protected $courses = ['Select Course'];

    public function __construct()
    {
        array_push($this->courses, ...Course::all()->pluck('name')->toArray());
    }

    /**
     * Prepare data for Faux Students request depends on selected course
     *
     * @param Request $request
     * @param mixed $resource
     *
     * @return array
     */
    public function getStudentData(StudentsRequest $request): array
    {
        $studentsData = [];

        $studentsData['courses'] = $this->courses;

        $data = $request->validated();

        $courseName = $data['course'] ?? null;
        $studentsPerPage = isset($data['per_page']) ? $data['per_page'] : 10;

        // Use session to store students data to provide the pagination
        $students = $request->session()->get('students');

        // Clean old data from session storage
        if (empty($data['course']) || $students && $courseName) {
            $request->session()->forget('students');
            $students = null;
        }

        if (!$students) {
            $students = $this->getStudents($courseName, $studentsPerPage);

            $request->session()->put('students', $students);
        }

        $studentsData['students'] = $students;
        $studentsData['courseName'] = $courseName;
        $studentsData['studentsPerPage'] = $studentsPerPage;

        return $studentsData;
    }

    /**
     * Get students collection depends on amount records on page and course name
     *
     * @param $courseName
     * @param $studentsPerPage
     *
     */
    protected function getStudents($courseName, $studentsPerPage)
    {
        return Student::with('group')->select('*')
            ->join('course_student', 'course_student.student_id', '=', 'students.id')
            ->join('courses', 'course_student.course_id', '=', 'courses.id')
            ->where('courses.name', $courseName)
            ->orderBy('students.id')
            ->paginate($studentsPerPage);
    }
}
