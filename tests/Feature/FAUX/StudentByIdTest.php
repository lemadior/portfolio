<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentByIdTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * The data set for testing 10 random student IDs
     *
     * @return array
     */
    public static function studentsIdProvider(): array
    {
        $studentRandomNumbers = [];

        for ($i = 1; $i <= 10; $i++) {
            $studentRandomNumbers[] = [rand(1, 200)];
        }

        return $studentRandomNumbers;
    }

    /**
     * A basic test to load student data page with specified id
     *
     * @dataProvider studentsIdProvider
     *
     * @return void
     */
    public function testShowStudentById($id): void
    {
        $response = $this->get("/faux/students/${id}");

        $response->assertStatus(200);
        $response->assertViewIs('faux.show');
    }
}
