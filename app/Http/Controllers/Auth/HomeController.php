<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)->take(4)->get();
        $categories = Category::all();
        $bestSellers = Product::orderBy('sales_count', 'desc')->take(4)->get();
        $popularProducts = Product::orderBy('views', 'desc')->take(4)->get();
        
        return view('home', compact('featuredProducts', 'categories', 'bestSellers', 'popularProducts'));
    }
}