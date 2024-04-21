<?php

namespace Tests\Traits;

use App\Models\Faux\Course;
use App\Models\Faux\Group;
use App\Models\Faux\Student;

trait DBSetup
{
    /**
     * @var array $groups
     */
    protected array $groups = [
        'IL-24',
        'YF-22',
        'JA-20',
        'CO-22',
        'NX-21',
        'XT-24',
        'IR-24',
        'KR-22',
        'KN-20',
        'HZ-22'
    ];

    /**
     * @var array $courseIds
     */
    protected array $courseIds = [
        [1], [2, 3], [4, 5, 6], [7], [8, 9], [10, 1, 2], [3], [4, 5], [6, 7, 8], [9], [10, 1], [2, 3, 4],
        [2], [6, 7], [8, 9, 10], [1], [2, 3], [4, 5, 6], [7], [8, 9], [10, 1, 2], [3], [4, 5], [6, 7, 8],
        [3], [10, 1], [2, 3, 4], [2], [6, 7], [8, 9, 10], [1], [2, 3], [4, 5, 6], [7], [8, 9], [10, 1, 2],
        [4], [4, 5], [6, 7, 8], [9], [7, 1], [2, 3, 4], [5], [6, 7], [8, 9, 10], [6], [2, 3], [4, 5, 6],
        [5], [8, 9], [10, 1, 2], [3], [4, 5], [6, 7, 7], [9], [10, 1], [2, 3, 4], [5], [6, 7], [8, 9, 10],
        [6], [2, 3], [4, 5, 6], [7], [2, 9], [10, 4, 2], [3],  [4, 5], [6, 7, 8], [9], [10, 1], [2, 3, 4],
        [7], [6, 7], [8, 9, 10], [1], [2, 3], [4, 9, 6], [7], [8, 9], [10, 1, 2], [1], [4, 5], [6, 7, 8],
        [8], [7, 1], [2, 3, 4], [5], [6, 7], [8, 9, 7], [1], [2, 3], [4, 9, 6], [7], [8, 9], [10, 1, 2],
        [9], [4, 5], [4, 7, 8], [9], [10, 1], [2, 3, 4], [5], [6, 7], [8, 9, 10], [1], [2, 3], [4, 5, 6],
        [7], [8, 9], [10, 1, 2], [3], [4, 5], [6, 7, 9], [9], [10, 1], [2, 3, 4], [5], [6, 7], [8, 9, 10],
        [1], [2, 3], [4, 9, 6], [7], [8, 9], [7, 1, 2], [3],  [4, 5], [6, 7, 8], [9], [10, 1], [2, 3, 4],
        [2], [6, 7], [8, 9, 10], [1], [2, 3], [4, 5, 6], [7], [8, 9], [10, 1, 2], [3], [4, 5], [6, 7, 8],
        [3], [10, 1], [2, 3, 4], [5], [6, 7], [8, 9, 10], [1], [2, 3], [4, 5, 6], [7], [8, 9], [10, 1, 2],
        [4], [4, 5], [9, 7, 8], [4], [10, 1], [2, 3, 4], [5], [6, 7], [8, 9, 10], [6], [2, 3], [4, 5, 6],
        [5], [8, 9], [10, 1, 2], [3], [4, 5], [6, 7, 7], [9], [10, 1], [2, 3, 4], [9], [6, 7], [8, 9, 10],
        [6], [2, 3], [4, 5, 6], [7], [8, 9], [10, 1, 2], [3],  [4, 9], [6, 7, 8], [8], [10, 1], [2, 3, 4],
        [7], [6, 2], [8, 2, 10], [1], [2, 8], [4, 9, 6], [7], [8, 9]
    ];

    protected function setDatabase(): void
    {
        $totalStudentsCount = 200;

        // dump('Fill the Course table');

        $courses = Course::factory(10)->create();

        // dump('Fill the Group table and correspondents Students');

        $totalCountStudentsInGroups = 0;

        for ($i = 1; $i <= 10; $i++) {

            $studentsCount = rand(10, 30);

            $studentsCount = $studentsCount < 10 ? 0 : $studentsCount;

            // If summary of the students exceed the self::TOTAL_STUDENTS_COUNT value
            if ($totalCountStudentsInGroups + $studentsCount > $totalStudentsCount) {
                $diff = $totalCountStudentsInGroups + $studentsCount - $totalStudentsCount;
                $studentsCount -= $diff;
            }

            $totalCountStudentsInGroups += $studentsCount;

            // Create groups and assigned specified amount of students to it
            Group::factory()
                ->state(['name' => $this->groups[$i - 1]])
                ->hasStudents(2 * ($i - 1) + 10)
                ->create();
        }

        $diff = $totalStudentsCount - $totalCountStudentsInGroups;

        // dump('Add left students record to the Students table');
        Student::factory(10)->create();

        // dump('Fill the course_student table');

        foreach (Student::all() as $index => $student) {
            // dump($index, $this->courseIds[$index]);
            $student->courses()->attach($this->courseIds[$index]);
        }
    }
}
