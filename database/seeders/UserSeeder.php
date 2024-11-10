<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Prabhash',
            'last_name' => 'Jha',
            'role' => '1',
            'email' => 'admin@admin.com',
            'password' => Hash::make("12345678"),
        ]);
    }
}