<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Log::insert([
        [
            'action' => 'User logged in',
            'user_id' => 1,
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(3),
        ],
        [
            'action' => 'User updated profile',
            'user_id' => 1,
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ],
        [
            'action' => 'Admin viewed logs',
            'user_id' => 1,
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ],
        [
            'action' => 'User logged out',
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}

}
