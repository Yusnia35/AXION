<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkspaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('workspaces')->updateOrInsert(
            ['id' => 1],
            [
                'nama' => 'Arunika Farm',
                'created_at' => now(),
            ]
        );
    }
}
