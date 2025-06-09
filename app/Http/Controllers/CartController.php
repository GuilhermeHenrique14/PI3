<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

        $cartItems = $cart->items()->with('product.category')->get()->filter(function ($item) {
            if (!$item->product) {
                $item->delete();
                return false;
            }
            return true;
        });

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total', 'cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
        $productId = $request->input('product_id');
        $quantityToAdd = (int) $request->input('quantity');
        $product = Product::findOrFail($productId);

        $existingCartItem = $cart->items()->where('product_id', $productId)->first();
        $currentQuantityInCart = $existingCartItem ? $existingCartItem->quantity : 0;
        $requestedTotalQuantity = $currentQuantityInCart + $quantityToAdd;

        if ($product->stock < $quantityToAdd && !$existingCartItem) {
            return redirect()->route('products.show', $product->slug)->with('error', 'Estoque (' . $product->stock . ') insuficiente para ' . $product->name . '.');
        }
        if ($existingCartItem && $product->stock < $requestedTotalQuantity) {
            return redirect()->route('cart.index')->with('error', 'Estoque (' . $product->stock . ') insuficiente para adicionar mais ' . $quantityToAdd . ' de ' . $product->name . '. Você já tem ' . $currentQuantityInCart . ' no carrinho.');
        }

        if ($existingCartItem) {
            $existingCartItem->quantity = $requestedTotalQuantity;
            $existingCartItem->save();
            $message = 'Quantidade de ' . $product->name . ' atualizada no carrinho!';
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantityToAdd,
            ]);
            $message = $product->name . ' adicionado ao carrinho!';
        }

        return redirect()->route('cart.index')->with('success', $message);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if (!$cartItem->cart || $cartItem->cart->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Ação não autorizada.');
        }
        if (!$cartItem->product) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('error', 'Este produto não está mais disponível e foi removido do seu carrinho.');
        }

        $currentQuantity = $cartItem->quantity;
        $newQuantity = $currentQuantity;

        if ($request->has('increase')) {
            $newQuantity = $currentQuantity + 1;
        } elseif ($request->has('decrease')) {
            $newQuantity = $currentQuantity - 1;
        } elseif ($request->filled('quantity')) {
            $validatedData = $request->validate(['quantity' => 'required|integer|min:0']);
            $newQuantity = (int) $validatedData['quantity'];
        }

        if ($newQuantity < 1) {
            $productName = $cartItem->product->name;
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', $productName . ' removido do carrinho.');
        }

        if ($cartItem->product->stock < $newQuantity) {
            return redirect()->route('cart.index')->with('error', 'Estoque (' . $cartItem->product->stock . ') insuficiente para ' . $cartItem->product->name . '. Solicitado: ' . $newQuantity);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Quantidade de ' . $cartItem->product->name . ' atualizada!');
    }

    public function remove(CartItem $cartItem)
    {
        if (!$cartItem->cart || $cartItem->cart->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Ação não autorizada.');
        }

        $productName = $cartItem->product ? $cartItem->product->name : 'Item';
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', $productName . ' removido do carrinho!');
    }

    public function clear()
    {
        $user = Auth::user();
        if ($user->cart) {
            $user->cart->items()->delete();
        }
        return redirect()->route('cart.index')->with('success', 'Carrinho esvaziado com sucesso!');
    }

    public function updateQuantityAjax(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Carrinho não encontrado.'], 404);
        }

        $productId = $request->product_id;
        $cartItem = $cart->items()->where('product_id', $productId)->with('product')->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Produto não encontrado no carrinho.'], 404);
        }
        if (!$cartItem->product) {
             $cartItem->delete();
             $newCartItems = $cart->items()->with('product')->get();
             $cartTotal = $newCartItems->sum(fn($item) => $item->product->price * $item->quantity);
             $cartItemCount = $newCartItems->sum('quantity');
            return response()->json([
                'success' => true,
                'message' => 'Produto não mais disponível e removido do carrinho.',
                'removed' => true,
                'productId' => $productId,
                'cartTotalFormatted' => number_format($cartTotal, 2, ',', '.'),
                'cartItemCount' => $cartItemCount
            ]);
        }

        $newQuantity = (int) $request->quantity;
        $product = $cartItem->product;

        if ($newQuantity === 0) {
            $cartItem->delete();
            $newCartItems = $cart->items()->with('product')->get();
            $cartTotal = $newCartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $cartItemCount = $newCartItems->sum('quantity');
            return response()->json([
                'success' => true,
                'message' => $product->name . ' removido do carrinho.',
                'removed' => true,
                'productId' => $productId,
                'cartTotalFormatted' => number_format($cartTotal, 2, ',', '.'),
                'cartItemCount' => $cartItemCount
            ]);
        }

        if ($product->stock < $newQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Estoque (' . $product->stock . ') insuficiente para ' . $product->name . '. Solicitado: ' . $newQuantity,
                'originalQuantity' => $cartItem->quantity
            ]);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        $itemSubtotal = $product->price * $newQuantity;
        $updatedCartItems = $cart->items()->with('product')->get();
        $cartTotal = $updatedCartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $cartItemCount = $updatedCartItems->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Quantidade de ' . $product->name . ' atualizada!',
            'productId' => $productId,
            'newQuantity' => $newQuantity,
            'itemSubtotalFormatted' => number_format($itemSubtotal, 2, ',', '.'),
            'cartTotalFormatted' => number_format($cartTotal, 2, ',', '.'),
            'cartItemCount' => $cartItemCount
        ]);
    }
}