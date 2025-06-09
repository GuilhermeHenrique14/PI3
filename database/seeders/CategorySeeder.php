<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Pode remover se não usar
use Illuminate\Database\Seeder;
use App\Models\Category; // Certifique-se que o namespace está correto

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate(
            ['name' => 'Jogos Steam', 'slug' => 'jogos-steam'],
            ['description' => 'Chaves de jogos para a plataforma Steam.']
        );
        Category::firstOrCreate(
            ['name' => 'Gift Cards PSN', 'slug' => 'gift-cards-psn'],
            ['description' => 'Créditos para a PlayStation Network.']
        );
        Category::firstOrCreate(
            ['name' => 'Gift Cards Xbox', 'slug' => 'gift-cards-xbox'],
            ['description' => 'Créditos para a Xbox Live.']
        );
        Category::firstOrCreate(
            ['name' => 'Gift Cards Netflix', 'slug' => 'gift-cards-netflix'],
            ['description' => 'Assinaturas e créditos Netflix.']
        );
        Category::firstOrCreate(
            ['name' => 'Jogos PC (Outros)', 'slug' => 'jogos-pc-outros'],
            ['description' => 'Jogos para PC de diversas plataformas.']
        );
        Category::firstOrCreate(
            ['name' => 'Gift Cards Google Play', 'slug' => 'gift-cards-google-play'],
            ['description' => 'Créditos para a Google Play Store.']
        );

        // ----> ADICIONANDO NOVAS CATEGORIAS <----

        // Exemplo 1: Fornecendo o nome e o slug explicitamente
        // Certifique-se que 'Gift Cards Riot' E 'gift-cards-riot' não existem juntos ainda.
        Category::firstOrCreate(
            ['name' => 'Gift Cards Riot', 'slug' => 'gift-cards-riot'],
            ['description' => 'Créditos para jogos da Riot Games (LoL, Valorant).']
        );

        Category::firstOrCreate(
            ['name' => 'Gift Cards Roblox Test', 'slug' => 'roblox-gift-cards-xyz123-unico'], // Nome e slug únicos
            ['description' => 'Teste para Robux na plataforma Roblox.']
        );

// Teste para Assinaturas de Software com slug manual e único
        Category::firstOrCreate(
            ['name' => 'Assinaturas Software Test', 'slug' => 'software-assinaturas-abc789-unico'], // Nome e slug únicos
            ['description' => 'Teste para Licenças de software.']
        );


        $this->command->info('CategorySeeder executado. Verifique as novas categorias.');
    }
}