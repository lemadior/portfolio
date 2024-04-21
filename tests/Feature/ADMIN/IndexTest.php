<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\AdminSetup;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase, AdminSetup, DBSetup;

    protected function setUp(): void
    {
        parent::SetUp();

        $this->setDatabase();
        $this->user = $this->createUser();
    }

    /**
     * The data set for testing amount returned records for different pagination settings
     *
     * @return array
     */
    public static function paginationDataProvider(): array
    {
        return [
            [5], [10], [15], [20]
        ];
    }

    /**
     * The data set for testing returned statuses from key pages
     *
     * @return array // [ [<per_page>, <pages_count>, <last_page_items_count>] ]
     */
    public static function paginationPerPageProvider(): array
    {
        return [
            [5, 40, 5],
            [10, 20, 10],
            [15, 14, 5],
            [20, 10, 20]
        ];
    }

    /**
     * Test if the students full list on main Admin Dashboard page displayed correctly
     */
    public function testFullStudentsListOnAdminDashboard(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/faux');

        $students = $response->viewData('students');
        $this->assertNotEmpty($students);

        $response->assertStatus(200);
        $response->assertViewIs('admin.faux.index');
    }


    /**
     * Test if the students partial list on main Admin Dashboard page displayed correctly
     */
    public function testPartialStudentsListOnAdminDashboardPagination(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/faux?page=2&per_page=15');

        $response->assertStatus(200);
        $response->assertViewIs('admin.faux.index');
        $this->assertEquals($response->viewData('studentsPerPage'), 15);
    }

    /**
     * Test if the students full list on main Admin Dashboard page displayed correctly
     * for different pagination settings
     *
     * @dataProvider paginationDataProvider
     *
     * @return void
     */
    public function testPartialStudentsListOnAdminDashboardWithPaginate($perPage): void
    {
        $response = $this->actingAs($this->user)->get("/admin/faux?per_page=${perPage}");

        $content = $response->getContent();
        $rowCount = substr_count($content, '<tr>') - 1;

        $students = $response->viewData('students');
        $this->assertNotEmpty($students);

        $response->assertStatus(200);
        $response->assertViewIs('admin.faux.index');

        $this->assertEquals($perPage, $rowCount);
        $this->assertEquals($perPage, $students->count());
    }

    /**
     * Test if the students full list on main Admin Dashboard page displayed correctly
     * for different pagination settings on the last page
     * (check if the pagination calculate correctly)
     *
     * @dataProvider paginationPerPageProvider
     *
     * @return void
     */
    public function testPartialStudentsListOnAdminDashboardForLastPage($perPage, $lastPage, $itemsCount): void
    {
        $response = $this->actingAs($this->user)->get("/admin/faux?page=${lastPage}&per_page=${perPage}");

        $content = $response->getContent();
        $rowCount = substr_count($content, '<tr>') - 1;

        $students = $response->viewData('students');
        $this->assertNotEmpty($students);

        $response->assertStatus(200);
        $response->assertViewIs('admin.faux.index');

        $this->assertEquals($itemsCount, $rowCount);
        $this->assertEquals($itemsCount, $students->count());
    }
}
