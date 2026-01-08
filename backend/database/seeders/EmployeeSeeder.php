<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'nip' => 'EMP001',
                'nama_lengkap' => 'Budi Santoso',
                'jabatan' => 'Staff Gudang',
                'departemen' => 'Gudang',
                'no_hp' => '08123456789',
                'alamat' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => 'EMP002',
                'nama_lengkap' => 'Siti Aminah',
                'jabatan' => 'Admin Gudang',
                'departemen' => 'Gudang',
                'no_hp' => '08129876543',
                'alamat' => 'Bekasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
