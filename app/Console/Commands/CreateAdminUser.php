<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user 
                            {--name= : Admin user name}
                            {--email= : Admin user email}
                            {--password= : Admin user password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user for the FreshFreeze application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name') ?? $this->ask('What is the admin name?', 'Administrator');
        $email = $this->option('email') ?? $this->ask('What is the admin email?', 'admin@freshfreeze.com');
        $password = $this->option('password') ?? $this->secret('What is the password for the admin?');
        
        if (User::where('email', $email)->exists()) {
            $this->error("A user with email {$email} already exists!");
            return 1;
        }
        
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        
        $this->info("Admin user created successfully!");
        $this->info("Email: {$email}");
        $this->info("Password: {$password} (Make sure to change this immediately!)");
        
        return 0;
    }
}
