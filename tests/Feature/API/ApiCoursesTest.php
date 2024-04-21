<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\AdminSetup;
use Tests\Traits\AuthSetup;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class ApiCoursesTest extends TestCase
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
     * Test get list of courses used token via API
     *
     * @return void
     */
    public function testApiGetCoursesWithToken(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $this->token,
            'Accept' => 'application/json'
        ])->get('/api/v1/courses');

        $data = $response->json();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('courses', $data['data']);
        $this->assertIsArray($data['data']['courses']);
        $this->assertEquals(10, count($data['data']['courses']));
    }

    /**
     * Test unauthorized access to the API URL to get courses list
     *
     * @return void
     */
    public function testApiGetCoursesWithUnauthorizedError(): void
    {
        $response = $this->get('/api/v1/courses');

        $response->assertStatus(401);

        $this->assertStringContainsString('Unauthorized', $response->getContent());
    }
}
