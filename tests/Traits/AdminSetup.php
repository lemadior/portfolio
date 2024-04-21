<?php

namespace Tests\Traits;

use App\Models\User;

trait AdminSetup
{
    protected User $user;

    /**
     * Create fake user for testing purposes only
     *
     * @return User
     */
    private function createUser(): User
    {
        return User::factory()->create([
            'name' => 'User',
            'email' => 'user@local.net',
            'password' => bcrypt('Aa5017.23846'),
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }
}
