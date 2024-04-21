<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseByIdTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * The data set with available course IDs
     *
     * @return array
     */
    public static function coursesIdProvider(): array
    {
        return [
            [1], [2], [3], [4], [5], [6], [7], [8], [9], [10]
        ];
    }

    /**
     * A basic test to load course page with specified id
     *
     * @dataProvider coursesIdProvider
     *
     * @return void
     */
    public function testShowCourseById($id): void
    {
        $response = $this->get("/faux/courses/${id}");

        $response->assertStatus(200);
        $response->assertViewIs('faux.course');
    }
}
