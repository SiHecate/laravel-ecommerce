<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $user = User::create([
            'role' => 'Admin',
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin1'),
        ]);
        
    }
}
