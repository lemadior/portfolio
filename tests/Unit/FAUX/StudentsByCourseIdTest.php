<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Faux\Student;
use App\Models\Faux\Course;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class StudentsByCourseIdTest extends TestCase
{
    use RefreshDatabase, DBSetup;

    public function setUp(): void
    {
        parent::setUp();

        $this->setDatabase();
    }

    /**
     * The data set for testing returned amount of students subscribed to each course
     *
     * @return array
     */
    public static function coursesFilterDataProvider(): array
    {
        return [
            [1, 36],
            [2, 46],
            [3, 37],
            [4, 45],
            [5, 31],
            [6, 42],
            [7, 45],
            [8, 39],
            [9, 43],
            [10, 35]
        ];
    }

    /**
     * A test if the amount of the students belongs to the certain course is calculated correctly
     *
     * @dataProvider coursesFilterDataProvider
     *
     */
    public function testStudentsByCourseId($courseId, $studentsAmount): void
    {
        $courseName = Course::where('id', $courseId)->get()->first()->name;

        $studentsOnCourse = Student::with('group')->select('*')
            ->join('course_student', 'course_student.student_id', '=', 'students.id')
            ->join('courses', 'course_student.course_id', '=', 'courses.id')
            ->where('courses.name', $courseName)
            ->orderBy('students.id')
            ->get()->count();

        $this->assertEquals($studentsAmount, $studentsOnCourse);
    }
}
