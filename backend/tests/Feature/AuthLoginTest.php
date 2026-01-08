<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthLoginTest extends TestCase
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

    public function test_user_can_login()
    {
        $response = $this->postJson('/api/login', [
            'username' => 'superadmin',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
    }

    public function test_login_fails_with_wrong_password()
    {
        $response = $this->postJson('/api/login', [
            'username' => 'superadmin',
            'password' => 'salah',
        ]);

        $response->assertStatus(422);
    }
}
