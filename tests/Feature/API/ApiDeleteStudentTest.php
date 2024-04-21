<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Faux\Student;
use Tests\Traits\AdminSetup;
use Tests\Traits\AuthSetup;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class ApiDeleteStudentTest extends TestCase
{
    use RefreshDatabase,
        AuthSetup,
        AdminSetup,
        DBSetup;

    protected function setUp(): void
    {
        parent::SetUp();

        $this->user = $this->createUser();
        $this->token = $this->getApiToken();
        $this->setDatabase();
    }

    /**
     * Test deletion specified student's record from 'students' table via API
     *
     * @return void
     */
    public function testApiDeleteStudentWithToken(): void
    {
        $studentsCountBefore = Student::all()->count();

        $studentId = 100;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $this->token,
            'Accept' => 'application/json'
        ])->delete("/api/v1/students/${studentId}");

        $response->assertStatus(200);

        $data = $response->json();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('message', $data['data']);

        $this->assertEquals("Student with ID ${studentId} was successfully deleted", $data['data']['message']);

        $studentsCountAfter = Student::all()->count();

        $this->assertLessThan($studentsCountBefore, $studentsCountAfter);
    }

    /**
     * Test unauthorized access to the deletion API URL
     *
     * @return void
     */
    public function testApiDeleteStudentWithUnauthorizedError(): void
    {
        $response = $this->delete('/api/v1/students/100');

        $response->assertStatus(401);

        $this->assertStringContainsString('Unauthorized', $response->getContent());
    }

    /**
     * Test errors occurs through the existent student record deletion
     *
     * @return void
     */
    public function testApiDeleteNonExistentStudent(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $this->token,
            'Accept' => 'application/json'
        ])->delete('/api/v1/students/500');

        $response->assertStatus(404);

        $data = $response->json();

        $this->assertArrayHasKey('message', $data);

        $this->assertEquals('No query results for model [App\\Models\\Faux\\Student] 500', $data['message']);
    }
}
