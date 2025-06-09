<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Slides para o Carrossel Principal
        $carouselSlides = [
            [
                'image' => 'storage/images/banners/banner2.jpg',
                'alt_text' => 'Promoção imperdível na TokenStore'
            ],
            [
                'image' => 'storage/images/banners/banner1.jpg',
                'alt_text' => 'Gift Cards Variados é na TokenStore'
            ],
            [
                'image' => 'storage/images/banners/banner3.jpg',
                'alt_text' => 'Lançamentos de Jogos Digitais - TokenStore'
            ],
        ];

        // Categorias em Destaque
        $specificSlugs = [
            'gift-cards-xbox',
            'gift-cards-psn',
            'jogos-steam',
            'gift-cards-netflix'
        ];
        $desiredFeaturedCount = 4;

        $featuredCategories = Category::whereIn('slug', $specificSlugs)
                                      ->take($desiredFeaturedCount)
                                      ->get();

        // Se menos categorias específicas foram encontradas, busca outras para completar
        if ($featuredCategories->count() < $desiredFeaturedCount) {
            $additionalCategoriesNeeded = $desiredFeaturedCount - $featuredCategories->count();
            $alreadyFetchedSlugs = $featuredCategories->pluck('slug')->toArray();

            $otherCategories = Category::whereNotIn('slug', $alreadyFetchedSlugs)
                                       ->orderBy('name', 'asc') // Ou 'created_at'
                                       ->take($additionalCategoriesNeeded)
                                       ->get();
            $featuredCategories = $featuredCategories->merge($otherCategories);
        }

        // Atribui ícones às categorias em destaque
        $featuredCategories = $featuredCategories->map(function ($category) {
            $category->icon_image = 'images/categories/default_category_icon.png'; // Ícone padrão

            // Ícones específicos baseados no slug
            if ($category->slug === 'gift-cards-xbox') $category->icon_image = 'storage/images/banners/xboxbanner.jpg';
            if ($category->slug === 'gift-cards-psn') $category->icon_image = 'storage/images/banners/psnbanner.jpg';
            if ($category->slug === 'jogos-steam') $category->icon_image = 'storage/images/banners/steambanner.jpg';
            if ($category->slug === 'gift-cards-netflix') $category->icon_image = 'storage/images/banners/netflixbanner.jpg';
            // Adicione mais ifs para outros ícones específicos aqui

            return $category;
        });

        // Produtos Populares (ex: os 8 mais recentes)
        $popularProducts = Product::with('category')
                                 ->orderBy('created_at', 'desc')
                                 ->take(4)
                                 ->get();

        return view('home', compact('carouselSlides', 'featuredCategories', 'popularProducts'));
    }
}