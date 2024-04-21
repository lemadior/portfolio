<?php

namespace Tests\Traits;

trait AuthSetup
{
    protected string $token;

    private function getApiToken(): string
    {
        $response = $this->actingAs($this->user)->post('/api/v1/auth/login', [
            'email' => 'user@local.net',
            'password' => 'Aa5017.23846'
        ]);

        $data = $response->json();

        return $data['access_token'];
    }
}
