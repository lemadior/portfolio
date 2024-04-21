<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\AdminSetup;
use App\Models\Faux\Student;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase, AdminSetup, DBSetup;

    protected function setUp(): void
    {
        parent::SetUp();

        $this->setDatabase();
        $this->user = $this->createUser();
    }

    /**
     * A basic test to check success of deleting the student's record from Admin Dashboard
     *
     * @return void
     */
    public function testAdminDashboardDeleteStudent(): void
    {
        $studentsCountBefore = Student::all()->count();

        $response = $this->actingAs($this->user)->delete('/admin/faux/students/1');

        $studentsCountAfter = Student::all()->count();

        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.faux.index');

        $this->assertLessThan($studentsCountBefore, $studentsCountAfter);
    }

    /**
     * A basic test to check if error occur for invalid student's ID on the 'students' table
     *
     * @return void
     */
    public function testAdminDashboardDeleteNonexistentIdErrors(): void
    {
        $response = $this->actingAs($this->user)->delete('/admin/faux/students/1');

        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.faux.index');

        $response = $this->actingAs($this->user)->delete('/admin/faux/students/1');

        $response->assertStatus(404);
    }
}
