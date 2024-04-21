<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Faux\Student;
use Tests\Traits\AdminSetup;
use Tests\Traits\AuthSetup;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class ApiEditStudentTest extends TestCase
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
     * Get student data by it ID from 'students' table
     *
     * @param int $studentId
     *
     * @return array
     */
    protected function getStudentData(int $studentId): array
    {
        $studentData = [];

        $student = Student::where('id', $studentId)->with('courses')->first();

        $studentData['id'] = $studentId;
        $studentData['group_id'] = $student->group_id;;
        $studentData['first_name'] = $student->first_name;
        $studentData['last_name'] = $student->last_name;
        $studentData['course_ids'] = $student->courses->pluck('id')->toArray();

        return $studentData;
    }

    /**
     * The data set for testing errors through unsuccessful student's record edition via API
     *
     * @return array
     */
    public static function errorsDataProvider(): array
    {
        return [
            [
                'group_id', 'The selected group id is invalid.', [
                    'student_id' => 1,
                    'group_id' => 20,
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'course_ids' => [5]
                ]
            ],
            [
                'first_name', 'The first name field is required.', [
                    'student_id' => 1,
                    'group_id' => 2,
                    'first_name' => '',
                    'last_name' => 'last_name',
                    'course_ids' => [5]
                ]
            ],
            [
                'last_name', 'The last name field is required.', [
                    'student_id' => 1,
                    'group_id' => 2,
                    'first_name' => 'first_name',
                    'last_name' => '',
                    'course_ids' => [5]
                ]
            ],
            [
                'course_ids', 'The course ids field is required.', [
                    'student_id' => 1,
                    'group_id' => 2,
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'course_ids' => []
                ]
            ],
            [
                'course_ids.0', 'The selected course_ids.0 is invalid.', [
                    'student_id' => 1,
                    'group_id' => 2,
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'course_ids' => [0]
                ]
            ]
        ];
    }

    /**
     * Test edition existent student's record in 'students' table via API
     *
     * @return void
     */
    public function testApiEditStudentWithToken(): void
    {
        $studentId = 1;

        $studentOld = $this->getStudentData($studentId);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $this->token,
            'Accept' => 'application/json'
        ])->patch("/api/v1/students/${studentId}", [
            'student_id' => 1,
            'group_id' => 1,
            'first_name' => 'Korben',
            'last_name' => 'Dallas',
            'course_ids' => [5, 6, 7]
        ]);

        $response->assertStatus(200);

        $data = $response->json();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('id', $data['data']);
        $this->assertArrayHasKey('group_id', $data['data']);
        $this->assertArrayHasKey('first_name', $data['data']);
        $this->assertArrayHasKey('last_name', $data['data']);
        $this->assertArrayHasKey('course_ids', $data['data']);

        // $this->assertEquals('Student data updated successfully', $data['data']['message']);

        $this->assertEquals($studentOld['id'], $data['data']['id']);
        $this->assertEquals($studentOld['group_id'], $data['data']['group_id']);
        $this->assertNotEquals($studentOld['first_name'], $data['data']['first_name']);
        $this->assertNotEquals($studentOld['last_name'], $data['data']['last_name']);
        $this->assertNotEqualsCanonicalizing($studentOld['course_ids'], $data['data']['course_ids']);
    }

    /**
     * Test unauthorized access to the edition student API URL
     *
     * @return void
     */
    public function testApiEditStudentWithUnauthorizedError(): void
    {
        $response = $this->patch('/api/v1/students/1', [
            'student_id' => 1,
            'group_id' => 1,
            'first_name' => 'Korben',
            'last_name' => 'Dallas',
            'course_ids' => [5, 6, 7]
        ]);

        $response->assertStatus(401);

        $this->assertStringContainsString('Unauthorized', $response->getContent());
    }

    /**
     * Test errors occurs through the new student record edition
     *
     * @dataProvider errorsDataProvider
     *
     * @return void
     */
    public function testApiEditStudentWithErrors($key, $message, $data): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $this->token,
            'Accept' => 'application/json'
        ])->patch('/api/v1/students/1', $data);

        $response->assertStatus(422);

        $data = $response->json();

        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey($key, $data['errors']);

        $this->assertEquals($message, $data['message']);
    }
}
