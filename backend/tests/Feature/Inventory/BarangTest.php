<?php

namespace Tests\Feature\Inventory;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Inventory\Barang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class BarangTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        /**
         * BYPASS SEMUA AUTHORIZATION
         * Fokus test ke ALUR, bukan permission
         */
        Gate::before(fn () => true);

        $role = Role::create([
            'name'  => 'admin',
            'label' => 'Admin',
        ]);

        $this->user = User::create([
            'username'  => 'admin',
            'password'  => Hash::make('password'),
            'role_id'   => $role->id,
            'is_active' => true,
        ]);

        // Jika API pakai Sanctum, ganti ke:
        // $this->actingAs($this->user, 'sanctum');
        $this->actingAs($this->user);
    }

    public function test_user_can_create_barang()
    {
        $response = $this->postJson('/api/v1/inventory/barangs', [
            'kode'   => 'BRG-001',
            'nama'   => 'Barang Test',
            'satuan' => 'pcs',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('barangs', [
            'kode'      => 'BRG-001',
            'nama'      => 'Barang Test',
            'is_active' => true,
        ]);
    }

    public function test_user_can_view_active_barang_list()
    {
        Barang::create([
            'kode'      => 'BRG-A',
            'nama'      => 'Barang Aktif',
            'satuan'    => 'pcs',
            'stok'      => 0,
            'is_active' => true,
        ]);

        Barang::create([
            'kode'      => 'BRG-B',
            'nama'      => 'Barang Nonaktif',
            'satuan'    => 'pcs',
            'stok'      => 0,
            'is_active' => false,
        ]);

        $this->getJson('/api/v1/inventory/barangs')
             ->assertStatus(200)
             ->assertJsonCount(1, 'data');
    }

    public function test_user_can_update_barang()
    {
        $barang = Barang::create([
            'kode'      => 'BRG-UPD',
            'nama'      => 'Barang Lama',
            'satuan'    => 'pcs',
            'stok'      => 0,
            'is_active' => true,
        ]);

        $response = $this->putJson(
            "/api/v1/inventory/barangs/{$barang->id}",
            ['nama' => 'Barang Diupdate']
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('barangs', [
            'id'   => $barang->id,
            'nama' => 'Barang Diupdate',
        ]);
    }

    public function test_user_can_deactivate_barang()
    {
        $barang = Barang::create([
            'kode'      => 'BRG-DEL',
            'nama'      => 'Barang Deactivate',
            'satuan'    => 'pcs',
            'stok'      => 5,
            'is_active' => true,
        ]);

        $response = $this->deleteJson(
            "/api/v1/inventory/barangs/{$barang->id}",
            ['reason' => 'rusak']
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('barangs', [
            'id'        => $barang->id,
            'is_active' => false,
        ]);
    }

    public function test_inactive_barang_only_visible_in_inactive_endpoint()
{
    Barang::create([
        'kode'      => 'BRG-INACT',
        'nama'      => 'Barang Inactive',
        'satuan'    => 'pcs',
        'stok'      => 0,
        'is_active' => false,
    ]);

    $this->getJson('/api/v1/inventory/barangs/inactive')
         ->assertStatus(200)
         ->assertJsonCount(1, 'data');
}
}
