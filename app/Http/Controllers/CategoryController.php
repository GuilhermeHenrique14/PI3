<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product; // Se for listar produtos
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the specified category and its products.
     *
     * @param  \App\Models\Category  $category  (Ou string $slug se não usar Route Model Binding diretamente para 'todos')
     * @return \Illuminate\View\View
     */
    public function show(string $slug) // Recebe o slug como string para poder tratar 'todos'
    {
        if ($slug === 'todos') {
            // Lógica para exibir todos os produtos de todas as categorias
            $categoryName = 'Todos os Produtos';
            $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(12); // Paginando
            return view('categories.show_all_products', compact('products', 'categoryName')); // Crie esta view
        }

        // Se não for 'todos', tenta encontrar a categoria pelo slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Carregar produtos desta categoria (exemplo com paginação)
        $products = Product::where('category_id', $category->id)
                             ->orderBy('created_at', 'desc')
                             ->paginate(12); // Ajuste o número por página

        return view('categories.show', compact('category', 'products')); // Crie esta view
    }
}