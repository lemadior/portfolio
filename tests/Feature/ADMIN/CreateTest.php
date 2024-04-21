<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Faux\Student;
use Tests\Traits\AdminSetup;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase, AdminSetup, DBSetup;

    protected function setUp(): void
    {
        parent::SetUp();

        $this->setDatabase();
        $this->user = $this->createUser();
    }

    /**
     *  The data set for testing possible error cases through create new student's record
     *
     * @return array
     */
    public static function validationDataProvider(): array
    {
        return [
            [
                'group_id', [
                    'group_id' => 20,
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'course_ids' => [5]
                ]
            ],
            [
                'first_name', [
                    'group_id' => 2,
                    'first_name' => '',
                    'last_name' => 'last_name',
                    'course_ids' => [5]
                ]
            ],
            [
                'last_name', [
                    'group_id' => 2,
                    'first_name' => 'first_name',
                    'last_name' => '',
                    'course_ids' => [5]
                ]
            ],
            [
                'course_ids', [
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
     * A test that the new student creation page loaded correctly
     *
     * @return void
     *
     */
    public function testLoadingAdminDashboardCreatePage(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/faux/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.faux.create');
    }

    /**
     * A test to check if the new user created correctly via Admin Dashboard
     *
     * @return void
     */
    public function testAdminDashboardCreateStudent(): void
    {
        $lastId = Student::all()->count();

        $response = $this->actingAs($this->user)->post('/admin/faux/store', [
            'group_id' => 5,
            'first_name' => 'Korben',
            'last_name' => 'Dallas',
            'course_ids' => [5, 7]
        ]);

        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.faux.index');

        $lastId = Student::all()->count();

        $student = $this->getStudentData($lastId);

        $this->assertEquals($student['group_id'], 5);
        $this->assertEquals($student['first_name'], 'Korben');
        $this->assertEquals($student['last_name'], 'Dallas');
        $this->assertEqualsCanonicalizing($student['course_ids'], [5, 7]);
    }

    /**
     * A multiple test to check validation errors on the create student page
     *
     * @dataProvider validationDataProvider
     *
     * @param $key // Name of the field in the form on edit page
     * @param $data // Data to change student's record
     *
     * @return void
     */
    public function testAdminDashboardCreationValidationErrors($key, $data): void
    {
        $response = $this->actingAs($this->user)->post('/admin/faux/store', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $response->assertInvalid($key);
    }
}
