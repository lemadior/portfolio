<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\AdminSetup;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, AdminSetup;

    protected function setUp(): void
    {
        parent::SetUp();

        $this->user = $this->createUser();
    }

    /**
     * Test if redirecting works for '/login' url to the '/admin' if user log in
     */
    public function testRedirectUserToAdminDashboardLoginFromAnyProtectedPage(): void
    {
        $response = $this->post('/auth/login', [
            'email' => 'user@local.net',
            'password' => 'Aa5017.23846'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/faux');
    }

    /**
     * Test if redirecting works for '/register' url to the '/login' after successful registration
     */
    public function testRedirectUserToAdminDashboardLoginAfterRegistration(): void
    {
        $response = $this->post('/auth/register', [
            'name' => 'User',
            'email' => 'admin@local.net',
            'password' => 'Aa5017.23846',
            'confirm' => 'Aa5017.23846',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/auth/login');
    }

    /**
     * Test if redirecting works for '/logout' url to the '/' if user log out
     */
    public function testRedirectUserAfterAdminDashboardLogoutToHome(): void
    {
        $response = $this->actingAs($this->user)->post('/auth/logout');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
