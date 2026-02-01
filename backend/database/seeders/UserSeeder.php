<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = DB::table('roles')->pluck('id', 'name');

        DB::table('users')->insert([
            [
                'username' => 'superadmin',
                'password' => Hash::make('superadmin123'),
                'role_id' => $roles['super_admin'],
                'employee_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role_id' => $roles['admin'],
                'employee_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'    => 'qc',
                'password'    => Hash::make('qc123'),
                'role_id'     => $roles['petugas_qc'],
                'employee_id' => 2,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
