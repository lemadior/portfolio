<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Faux\Student;
use Tests\Traits\AdminSetup;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase, AdminSetup, DBSetup;

    protected function setUp(): void
    {
        parent::SetUp();

        $this->setDatabase();
        $this->user = $this->createUser();
    }

    /**
     * The data set for testing possible error cases through edit student's record
     *
     * @return array
     */
    public static function validationDataProvider(): array
    {
        return [
            [
                'group_id', [
                    'student_id' => 1,
                    'group_id' => 20,
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'course_ids' => [5]
                ]
            ],
            [
                'first_name', [
                    'student_id' => 1,
                    'group_id' => 2,
                    'first_name' => '',
                    'last_name' => 'last_name',
                    'course_ids' => [5]
                ]
            ],
            [
                'last_name', [
                    'student_id' => 1,
                    'group_id' => 2,
                    'first_name' => 'first_name',
                    'last_name' => '',
                    'course_ids' => [5]
                ]
            ],
            [
                'course_ids', [
                    'student_id' => 1,
                    'group_id' => 2,
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'course_ids' => []
                ]
            ]
        ];
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
     * A basic test to show edit page for specified student's id on Admin Dashboard
     *
     * @return void
     */
    public function testAdminDashboardEditPage(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/faux/students/1/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.faux.edit');
    }

    /**
     * A basic test to check successful editing student's data
     * (changed: name and courses)
     *
     * @return void
     */
    public function testAdminDashboardEditStudentDataNameAndCourses(): void
    {
        $studentId = 1;

        $studentOld = $this->getStudentData($studentId);

        $response = $this->actingAs($this->user)->patch("/admin/faux/students/${studentId}", [
            'student_id' => 1,
            'group_id' => 1,
            'first_name' => 'Korben',
            'last_name' => 'Dallas',
            'course_ids' => [5, 6, 7]
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('faux.show');

        $studentNew = $this->getStudentData($studentId);

        $this->assertEquals($studentOld['id'], $studentNew['id']);
        $this->assertEquals($studentOld['group_id'], $studentNew['group_id']);
        $this->assertNotEquals($studentOld['first_name'], $studentNew['first_name']);
        $this->assertNotEquals($studentOld['last_name'], $studentNew['last_name']);
        $this->assertNotEqualsCanonicalizing($studentOld['course_ids'], $studentNew['course_ids']);
    }

    /**
     * A basic test to check successful editing student's data
     * (changed: group and courses)
     *
     * @return void
     */
    public function testAdminDashboardEditStudentDataGroupAndCourse(): void
    {
        $studentId = 191;

        $studentOld = $this->getStudentData($studentId);

        $response = $this->actingAs($this->user)->patch("/admin/faux/students/${studentId}", [
            'student_id' => 1,
            'group_id' => 2,
            'first_name' => $studentOld['first_name'],
            'last_name' => $studentOld['last_name'],
            'course_ids' => [5]
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('faux.show');

        $studentNew = $this->getStudentData($studentId);

        $this->assertEquals($studentOld['id'], $studentNew['id']);
        $this->assertNotEquals($studentOld['group_id'], $studentNew['group_id']);
        $this->assertEquals($studentOld['first_name'], $studentNew['first_name']);
        $this->assertEquals($studentOld['last_name'], $studentNew['last_name']);
        $this->assertNotEqualsCanonicalizing($studentOld['course_ids'], $studentNew['course_ids']);
    }

    /**
     * A basic test to check availability of main pages
     *
     * @dataProvider validationDataProvider
     *
     * @param $key // Name of the field in the form on edit page
     * @param $data // Data to change student's record
     *
     * @return void
     */
    public function testAdminDashboardEditValidationErrors($key, $data): void
    {
        $response = $this->actingAs($this->user)->patch('/admin/faux/students/1', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $response->assertInvalid($key);
    }
}
