<?php

namespace Tests\Feature;

use Tests\TestCase;

class RedirectTest extends TestCase
{
    /**
     * Test if redirecting works for '/admin' url to the '/login' if user wasn't log in
     */
    public function testRedirectFromAdminToLogin(): void
    {
        $response = $this->get('/admin/faux');

        $response->assertStatus(302);
        $response->assertRedirect('/auth/login');
    }
}
