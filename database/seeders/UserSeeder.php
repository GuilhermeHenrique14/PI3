<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Certifique-se de que o namespace do seu modelo User está correto
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'guilherme@gmail.com'], // Condições para encontrar o usuário
            [                                   // Valores para criar um novo usuário ou ATUALIZAR um existente
                'name' => 'Admin User',
                'password' => Hash::make('1234qwer'), // A senha será hasheada
                'is_admin' => true,                   // Define como administrador
                // Adicione 'email_verified_at' se você usa verificação de e-mail e quer marcar como verificado
                // 'email_verified_at' => now(),
            ]
        );

        // Opcional: Adicionar uma mensagem de feedback no console quando o seeder rodar
        $this->command->info('Usuário admin guilherme@gmail.com foi criado ou atualizado com sucesso.');

        // Você pode adicionar outros usuários aqui se precisar, por exemplo:
        // User::updateOrCreate(
        //     ['email' => 'cliente@example.com'],
        //     [
        //         'name' => 'Cliente Teste',
        //         'password' => Hash::make('senhaCliente'),
        //         'is_admin' => false,
        //     ]
        // );
    }
}