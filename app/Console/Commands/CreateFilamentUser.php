<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateFilamentUser extends Command
{
    protected $signature = 'filament:create-user';
    protected $description = 'Create a new Filament admin user';

    public function handle()
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            // pastikan ada role admin atau is_admin disini jika pakai role
        ]);

        $this->info('User berhasil dibuat dengan email: ' . $email);
    }
}
