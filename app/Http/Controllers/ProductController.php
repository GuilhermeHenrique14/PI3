<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);
        $categoryName = null;
        $selectedCategorySlug = $request->query('category');

        if ($selectedCategorySlug && $selectedCategorySlug !== '') {
            $category = Category::where('slug', $selectedCategorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
                $categoryName = $category->name;
            }
        }

        if ($request->has('product_search') && $request->product_search !== '') {
            $searchTermFromIndex = $request->product_search;
            $query->where(function ($q) use ($searchTermFromIndex) {
                $q->where('name', 'like', '%' . $searchTermFromIndex . '%')
                  ->orWhere('platform', 'like', '%' . $searchTermFromIndex . '%')
                  ->orWhere('description', 'like', '%' . $searchTermFromIndex . '%');
            });
        }

        if ($request->has('sort_by')) {
            switch ($request->sort_by) {
                case 'price_asc': $query->orderBy('price', 'asc'); break;
                case 'price_desc': $query->orderBy('price', 'desc'); break;
                case 'name_asc': $query->orderBy('name', 'asc'); break;
                case 'name_desc': $query->orderBy('name', 'desc'); break;
                case 'latest': $query->orderBy('created_at', 'desc'); break;
                default: $query->orderBy('created_at', 'desc'); break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->appends($request->except('page'));
        
        $categories = Category::has('products')->orderBy('name')->get();
        
        $searchTermToDisplay = $request->product_search ?? null;

        return view('products.index', compact('products', 'categories', 'categoryName', 'selectedCategorySlug', 'searchTermToDisplay'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        $relatedProducts = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('query'); 

        if (empty(trim($searchTerm))) {
            return redirect()->route('products.index');
        }
        return redirect()->route('products.index', ['product_search' => $searchTerm]);
    }
}