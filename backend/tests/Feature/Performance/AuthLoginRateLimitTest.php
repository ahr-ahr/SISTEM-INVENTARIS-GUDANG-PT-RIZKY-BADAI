<?php

namespace Tests\Feature\Performance;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthLoginStressTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::create([
            'name'  => 'super_admin',
            'label' => 'Super Admin',
        ]);

        User::create([
            'username'  => 'superadmin',
            'password'  => Hash::make('password'),
            'role_id'   => $role->id,
            'is_active' => true,
        ]);
    }

    public function test_login_is_rate_limited_under_load()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/login', [
                'username' => 'superadmin',
                'password' => 'password',
            ])->assertSuccessful();
        }

        $this->postJson('/api/login', [
            'username' => 'superadmin',
            'password' => 'password',
        ])->assertStatus(429);
    }
}
