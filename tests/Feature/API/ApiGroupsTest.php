<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\AdminSetup;
use Tests\Traits\AuthSetup;
use Tests\Traits\DBSetup;
use Tests\TestCase;

class ApiGroupsTest extends TestCase
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
     * Test retrieving the groups list via API
     *
     * @return void
     */
    public function testApiGetGroupsWithToken(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $this->token,
            'Accept' => 'application/json'
        ])->get("/api/v1/groups");

        $data = $response->json();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('groups', $data['data']);
        $this->assertIsArray($data['data']['groups']);
        $this->assertEquals(10, count($data['data']['groups']));
    }

    /**
     * Test unauthorized access to the API URL to get groups list
     *
     * @return void
     */
    public function testApiGetGroupsWithUnauthorizedError(): void
    {
        $response = $this->get('/api/v1/groups');

        $response->assertStatus(401);

        $this->assertStringContainsString('Unauthorized', $response->getContent());
    }
}
