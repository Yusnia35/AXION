<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['id' => 1],
            [
                'workspace_id' => 1,
                'nama' => 'Yusnia Rizki',
                'email' => 'yusnia@arunika.test',
                'password_hash' => Hash::make('password'),
                'role' => 'farm_manager',
                'is_active' => 1,
                'created_at' => now(),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@axion.test'],
            [
                'workspace_id' => 1,
                'nama' => 'Administrator AXION',
                'email' => 'admin@axion.test',
                'password_hash' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => now(),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'user@axion.test'],
            [
                'workspace_id' => 1,
                'nama' => 'Budi Santoso',
                'email' => 'user@axion.test',
                'password_hash' => Hash::make('password'),
                'role' => 'operator',
                'is_active' => 1,
                'created_at' => now(),
            ]
        );
    }
}
