<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout()
    {
        $cart = Auth::user()->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio!');
        }
        $cart->load('items.product'); 
        
        return view('orders.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,pix',
        ]);
        
        $user = Auth::user();
        $cart = $user->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio!');
        }

        $cart->load('items.product');

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($cart->items as $item) {
                if ($item->product) {
                    /*
                    if ($item->product->stock < $item->quantity) {
                        DB::rollBack();
                        return redirect()->route('cart.index')->with('error', "Desculpe, o produto '{$item->product->name}' não possui estoque suficiente ({$item->product->stock} disponíveis) para a quantidade solicitada ({$item->quantity}).");
                    }
                    */
                    $total += $item->product->price * $item->quantity;
                } else {
                    DB::rollBack(); 
                    return redirect()->route('cart.index')->with('error', 'Ocorreu um problema com um item no seu carrinho (produto não encontrado). Por favor, tente removê-lo e adicioná-lo novamente.');
                }
            }
            
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
            ]);
            
            foreach ($cart->items as $item) {
                if ($item->product) {
                    $order->items()->create([
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                    ]);

                    $productToUpdate = $item->product; 
                    
                    if ($productToUpdate) {
                        $productToUpdate->decrement('stock', $item->quantity);
                    } else {
                        Log::error("Produto ID {$item->product_id} não encontrado ao tentar decrementar estoque para o pedido {$order->id}. Isso não deveria acontecer se o produto estava no carrinho.");
                        throw new \Exception("Erro crítico: Produto não encontrado ao atualizar estoque para o item {$item->product_id} no pedido {$order->id}.");
                    }
                }
            }
            
            $cart->items()->delete();
            // $cart->delete(); 

            DB::commit();

            return redirect()->route('orders.confirmation', $order->id)->with('success', 'Seu pedido (simulado) foi realizado com sucesso e o estoque atualizado!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error("Erro ao processar pedido e atualizar estoque para o usuário ID {$user->id}: " . $e->getMessage() . " no arquivo " . $e->getFile() . " na linha " . $e->getLine());
            
            return redirect()->route('cart.index')->with('error', 'Ocorreu um erro ao processar seu pedido. Por favor, tente novamente. Se o problema persistir, contate o suporte.');
        }
    }

    public function confirmation(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a este pedido.');
        }
        
        $order->load(['items.product' => function ($query) {
            $query->select('id', 'name', 'image_path');
        }]);
        
        return view('orders.confirmation', compact('order'));
    }

    public function index()
    {
        $orders = Auth::user()
                        ->orders()
                        ->with(['items' => function ($query) {
                            $query->with(['product' => function ($productQuery) {
                                $productQuery->select('id', 'name', 'image_path');
                            }])->select('id', 'order_id', 'product_id', 'quantity', 'price');
                        }])
                        ->select('id', 'user_id', 'created_at', 'status', 'payment_status', 'total')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a este pedido.');
        }
        
        $order->load(['items.product' => function ($query) {
            $query->select('id', 'name', 'image_path');
        }]);
        
        return view('orders.show', compact('order'));
    }
}