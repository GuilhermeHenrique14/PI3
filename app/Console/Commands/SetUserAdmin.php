<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash; // Se precisar criar um usuário novo

class SetUserAdmin extends Command
{
    protected $signature = 'user:set-admin {email}'; // Pede o email como argumento
    protected $description = 'Set a user as an administrator';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");

            // Opcional: Criar o usuário se ele não existir
            // if ($this->confirm('User not found. Do you want to create this user as admin?')) {
            //     $name = $this->ask('Enter user name:');
            //     $password = $this->secret('Enter user password (will be hashed):');
            //     $user = User::create([
            //         'name' => $name,
            //         'email' => $email,
            //         'password' => Hash::make($password),
            //         'is_admin' => true,
            //         'email_verified_at' => now(), // Opcional: marcar como verificado
            //     ]);
            //     $this->info("User {$user->name} <{$user->email}> created and set as admin successfully!");
            //     return 0;
            // }
            return 1; // Código de erro
        }

        $user->is_admin = true;
        $user->save();

        $this->info("User {$user->name} <{$user->email}> is now an administrator.");
        return 0; // Código de sucesso
    }
}