<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating default admin users...');
        
        // Create main admin user if not exists
        if (!User::where('email', 'admin@freshfreeze.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@freshfreeze.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
            
            $this->command->info('Admin user created: admin@freshfreeze.com / password123');
        } else {
            $this->command->info('Admin user already exists: admin@freshfreeze.com');
        }
        
        // Create another admin user for testing
        if (!User::where('email', 'superadmin@freshfreeze.com')->exists()) {
            User::create([
                'name' => 'Super Administrator',
                'email' => 'superadmin@freshfreeze.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
            
            $this->command->info('Admin user created: superadmin@freshfreeze.com / password123');
        } else {
            $this->command->info('Admin user already exists: superadmin@freshfreeze.com');
        }
        
        // Create additional test admin
        if (!User::where('email', 'testadmin@freshfreeze.com')->exists()) {
            User::create([
                'name' => 'Test Administrator',
                'email' => 'testadmin@freshfreeze.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
            
            $this->command->info('Admin user created: testadmin@freshfreeze.com / password123');
        } else {
            $this->command->info('Admin user already exists: testadmin@freshfreeze.com');
        }
        
        $this->command->info('Admin user creation completed.');
    }
}