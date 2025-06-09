<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Supondo que você use
use App\Models\Category; // Supondo que você use

class HomeController extends Controller
{
    public function index()
    {
        $carouselSlides = [
            [
                'image' => 'storage/images/banners/banner2.jpg', // Mantenha seus caminhos corretos
                'alt_text' => 'Promoção imperdível na TokenStore',
                'title' => 'Ofertas Que Incendeiam!', // NOVO
                'subtitle' => 'Os melhores descontos em jogos e gift cards estão aqui. Não perca!' // NOVO
            ],
            [
                'image' => 'storage/images/banners/banner1.jpg',
                'alt_text' => 'Gift Cards Variados é na TokenStore',
                'title' => 'Seu Crédito Digital, Facilitado!', // NOVO
                'subtitle' => 'Recarregue suas contas favoritas de forma rápida e segura.' // NOVO
            ],
            [
                'image' => 'storage/images/banners/banner3.jpg',
                'alt_text' => 'Lançamentos de Jogos Digitais - TokenStore',
                'title' => 'Novidades Fresquinhas Chegando!', // NOVO
                'subtitle' => 'Confira os últimos lançamentos e prepare-se para a diversão.' // NOVO
            ],
            // Adicione mais slides conforme necessário
        ];

        // Seu código existente para $featuredCategories e $popularProducts permanece aqui...
        // Exemplo:
        $specificSlugs = [
            'gift-cards-xbox', 'gift-cards-psn', 'jogos-steam', 'gift-cards-netflix'
        ];
        $desiredFeaturedCount = 4;
        $featuredCategories = Category::whereIn('slug', $specificSlugs)->take($desiredFeaturedCount)->get();
        if ($featuredCategories->count() < $desiredFeaturedCount) {
            $additionalCategoriesNeeded = $desiredFeaturedCount - $featuredCategories->count();
            $alreadyFetchedSlugs = $featuredCategories->pluck('slug')->toArray();
            $otherCategories = Category::whereNotIn('slug', $alreadyFetchedSlugs)
                                       ->orderBy('name', 'asc')
                                       ->take($additionalCategoriesNeeded)
                                       ->get();
            $featuredCategories = $featuredCategories->merge($otherCategories);
        }
        $featuredCategories = $featuredCategories->map(function ($category) {
            // Use asset() para garantir o caminho público correto
            $category->icon_image = asset('images/categories/default_category_icon.png');
            if ($category->slug === 'gift-cards-xbox') $category->icon_image = asset('storage/images/banners/xboxbanner.jpg');
            if ($category->slug === 'gift-cards-psn') $category->icon_image = asset('storage/images/banners/psnbanner.jpg');
            if ($category->slug === 'jogos-steam') $category->icon_image = asset('storage/images/banners/steambanner.jpg');
            if ($category->slug === 'gift-cards-netflix') $category->icon_image = asset('storage/images/banners/netflixbanner.jpg');
            return $category;
        });

        $popularProducts = Product::with('category')
                                 ->orderBy('created_at', 'desc')
                                 ->take(4)
                                 ->get();
        // Fim do exemplo

        return view('home', compact('carouselSlides', 'featuredCategories', 'popularProducts'));
    }
}