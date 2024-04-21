<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Faux\Course;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class CoursesTest extends TestCase
{
    use RefreshDatabase, DBSetup;

    public function setUp(): void
    {
        parent::setUp();

        $this->setDatabase();
    }

    /**
     * The data set for testing returned name of course and it description
     *
     * @return array
     */
    public static function coursesNameProvider(): array
    {
        return [
            ['Math', 'Language of God to create Universes'],
            ['Biology', 'What inside the creatures'],
            ['Pneumatology', 'Learn how works pneumatic weapon'],
            ['History', 'Forgot all you know before'],
            ['Astronomy', 'We are not alone'],
            ['Philosophy', 'To be or not to be'],
            ['Chemistry', 'Miracle is possible'],
            ['Physics', 'Gravity is not a force. It is a wave'],
            ['Linguistics', 'How to say HELLO in Klingon'],
            ['Economics', 'Why am I so poor']
        ];
    }

    /**
     * A test if the Course model has been setup 'courses' table correctly.
     *
     * @dataProvider coursesNameProvider
     *
     */
    public function testCourseDataFromDatabase($course, $description): void
    {
        $courses = Course::all()->pluck('description', 'name')->toArray();

        $this->assertEquals($courses[$course], $description);
    }
}
