<?php

namespace Database\Seeders;

use App\Models\Faux\Course;
use App\Models\Faux\Group;
use App\Models\Faux\Student;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const TOTAL_STUDENTS_COUNT = 200;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //dump('Start the seeder');
        // dump('Fill the Course table');

        // Fill 'courses' table
        $courses = Course::factory(10)->create();

        // dump('Fill the Group table and correspondents Students');

        $totalCountStudentsInGroups = 0;

        for ($i = 1; $i <= 10; $i++) {

            $studentsCount = rand(10, 30);

            $studentsCount = $studentsCount < 10 ? 0 : $studentsCount;

            // If summary of the students exceed the self::TOTAL_STUDENTS_COUNT value
            if ($totalCountStudentsInGroups + $studentsCount > self::TOTAL_STUDENTS_COUNT) {
                $diff = $totalCountStudentsInGroups + $studentsCount - self::TOTAL_STUDENTS_COUNT;
                $studentsCount -= $diff;
            }

            $totalCountStudentsInGroups += $studentsCount;

            // Create groups and assigned specified amount of students to it
            // Simultaneously fill the 'students' table
            Group::factory()
                ->hasStudents($studentsCount)
                ->create();
        }

        $diff = self::TOTAL_STUDENTS_COUNT - $totalCountStudentsInGroups;

        // If has the unfilled position for the 'students' table - fill them
        // Depend on the self::TOTAL_STUDENTS_COUNT
        if ($diff) {
            // dump('Add left students record to teh Students table');
            Student::factory($diff)->create();
        }

        // dump('Fill the course_student table');

        // Fill the 'course_student' table
        foreach (Student::all() as $student) {
            $courseIds = $courses->random(3)->pluck('id');
            $courseIds = array_slice($courseIds->toArray(), 0, rand(1, 3));

            $student->courses()->attach($courseIds);
        }

    }
}
