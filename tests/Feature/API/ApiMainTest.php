<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\AdminSetup;
use Tests\Traits\AuthSetup;
use Tests\TestCase;

class ApiMainTest extends TestCase
{
    use RefreshDatabase,
        AuthSetup,
        AdminSetup;

    protected function setUp(): void
    {
        parent::SetUp();

        $this->user = $this->createUser();
    }

    /**
     * Test main api page (documentation)
     *
     * @return void
     */
    public function testApiDocumentationPage(): void
    {
        $response = $this->withoutExceptionHandling()->get('/api/v1/documentation');

        $response->assertSee('FAUX: L5 Swagger UI');
    }

    /**
     * Test main api page. Check success when try to get proper token
     *
     * @return void
     */
    public function testApiGetToken(): void
    {
        $response = $this->actingAs($this->user)->post('/api/v1/auth/login', [
            "email" => 'user@local.net',
            'password' => 'Aa5017.23846'
        ]);

        $data = $response->json();

        $this->assertArrayHasKey('access_token', $data);
        $this->assertArrayHasKey('token_type', $data);
        $this->assertArrayHasKey('expires_in', $data);

        $this->assertEquals('bearer', $data['token_type']);
        $this->assertEquals(3600, $data['expires_in']);
    }

    /**
     * Test main api page with wrong token
     *
     * @return void
     */
    public function testApiGetTokenUnauthorizedError(): void
    {
        $response = $this->actingAs($this->user)->post('/api/v1/auth/login', [
            'email' => 'user@local.net',
            'password' => 'wrong_password'
        ]);

        $data = $response->json();

        $this->assertArrayHasKey('error', $data);

        $this->assertEquals('Unauthorized', $data['error']);
    }
}
