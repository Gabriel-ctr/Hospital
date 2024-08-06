<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'age' => 30,
            ]);
        }

        if (!User::where('email', 'doctor@example.com')->exists()) {
            User::create([
                'name' => 'Doctor John',
                'email' => 'doctor@example.com',
                'password' => bcrypt('password'),
                'role' => 'doctor', // Role for doctor
                'age' => 40,
            ]);
        }
        
        if (!User::where('email', 'patient@example.com')->exists()) {
            User::create([
                'name' => 'Patient Jane',
                'email' => 'patient@example.com',
                'password' => bcrypt('password'),
                'role' => 'patient', // Role for patient
                'age' => 25,
            ]);
        }
    }
}
