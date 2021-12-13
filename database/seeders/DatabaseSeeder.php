<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'admin@admin.com',
            'name' => 'Administrator',
            'password' => bcrypt('VerySecurePassword'),
            'admin' => true,
        ]);
    }
}
