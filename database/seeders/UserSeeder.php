<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name'     => 'Reader',
            'email'    => 'reader@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
