<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentsByCourseIdTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     *  A basic test to check if find students by course name works correctly
     *
     * @return void
     */
    public function testReturnsStudentsByCourseName(): void
    {
        $response = $this->post('/faux/filter/students', ['course' => 'Math']);

        $content = $response->getContent();
        $rowCount = substr_count($content, '<tr>');

        $response->assertStatus(200);
        $response->assertViewIs('faux.students');

        // If more than 1 row present on the page it means that all works correctly
        $this->assertGreaterThan(1, $rowCount);
    }
}
