<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart || !$cart->items()->exists()) {
            return redirect()->route('cart.index')->with('info', 'Seu carrinho está vazio. Adicione itens antes de ir para o checkout.');
        }

        return view('orders.checkout', compact('cart'));     
    }
}