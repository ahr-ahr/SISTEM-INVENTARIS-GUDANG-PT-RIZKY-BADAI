<?php

namespace Tests\Feature\Performance;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class InternalApiRateLimiterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(fn () => true);

        // Login user (karena limiter pakai user->id)
        $role = Role::create([
            'name'  => 'admin',
            'label' => 'Admin',
        ]);

        $user = User::create([
            'username'  => 'admin',
            'password'  => Hash::make('password'),
            'role_id'   => $role->id,
            'is_active' => true,
        ]);

        $this->actingAs($user);
    }

    public function test_internal_api_rate_limit_allows_requests_under_limit()
    {
        for ($i = 0; $i < 120; $i++) {
            $this->getJson('/api/v1/inventory/barangs')
                 ->assertStatus(200);
        }
    }

    public function test_internal_api_rate_limit_blocks_requests_over_limit()
    {
        for ($i = 0; $i < 120; $i++) {
            $this->getJson('/api/v1/inventory/barangs')
                 ->assertStatus(200);
        }

        // Request ke-121
        $this->getJson('/api/v1/inventory/barangs')
             ->assertStatus(429);
    }
}
