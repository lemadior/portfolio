<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\AdminSetup;
use Tests\Traits\AuthSetup;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class ApiStudentsTest extends TestCase
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
     * Test retrieving the students list via API
     *
     * @return void
     */
    public function testApiGetStudentsWithToken(): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer" . $this->token,
            'Accept' => 'application/json'
        ])->get("/api/v1/students");

        $data = $response->json();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('students', $data['data']);
        $this->assertIsArray($data['data']['students']);
        $this->assertEquals(200, count($data['data']['students']));
    }

    /**
     * Test unauthorized access to the API URL to get students list
     *
     * @return void
     */
    public function testApiGetStudentsWithUnauthorizedError(): void
    {
        $response = $this->get("/api/v1/students");

        $response->assertStatus(401);

        $this->assertStringContainsString('Unauthorized', $response->getContent());
    }
}
