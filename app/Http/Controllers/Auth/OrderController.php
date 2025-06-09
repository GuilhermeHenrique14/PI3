<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\GiftCard; // Importe seu modelo de GiftCard
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Aplica o middleware 'auth' a todos os métodos, exceto 'confirmation' se desejado.
     * Ou você pode aplicar a métodos específicos.
     */
    public function __construct()
    {
        $this->middleware('auth'); // Garante que o usuário esteja logado para acessar qualquer método
    }

    /**
     * Display the checkout page.
     */
    public function checkout()
    {
        $cart = Auth::user()->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio!');
        }
        
        return view('orders.checkout', compact('cart'));
    }

    /**
     * Process the order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,pix', // Adicionado 'pix' como opção de pagamento
        ]);
        
        $cart = Auth::user()->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio!');
        }
        
        // Criar novo pedido
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $cart->total(),
            'status' => 'pending', // Pode ser 'processing' dependendo do seu gateway de pagamento
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending', // Pode ser 'paid' se o pagamento for instantâneo
        ]);
        
        // Criar itens do pedido
        foreach ($cart->items as $item) {
            $order->items()->create([
                'gift_card_id' => $item->gift_card_id, // Use 'gift_card_id' para consistência
                'quantity' => $item->quantity,
                'price' => $item->giftCard->price, // Use $item->giftCard->price se o relacionamento for giftCard
                                                   // Se o relacionamento no CartItem for product, mantenha $item->product->price
                // 'gift_card_code' => 'GERAR_CODIGO_UNICO_AQUI', // Adicione lógica para gerar/atribuir o código
            ]);
        }
        
        // Limpar carrinho
        $cart->items()->delete();
        $cart->delete(); // Se o Cart é criado por usuário, pode ser necessário deletá-lo também

        // Redirecionar para a página de confirmação
        return redirect()->route('orders.confirmation', $order->id)->with('success', 'Seu pedido foi realizado com sucesso!');
    }

    /**
     * Display the order confirmation page.
     */
    public function confirmation(Order $order) // Use Route Model Binding para simplificar
    {
        // Garante que o pedido pertence ao usuário logado
        if ($order->user_id !== Auth::id()) {
            abort(403); // Acesso negado
        }
        
        // Carrega os itens do pedido e seus produtos (Gift Cards) relacionados
        $order->load('items.giftCard'); // Ajuste 'product' para 'giftCard' se esse for o nome do seu relacionamento
                                         // Se o relacionamento no OrderItem for public function product(), mantenha 'items.product'
        
        return view('orders.confirmation', compact('order'));
    }

    /**
     * Display the user's orders.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order) // Use Route Model Binding para simplificar
    {
        // Garante que o pedido pertence ao usuário logado
        if ($order->user_id !== Auth::id()) {
            abort(403); // Acesso negado
        }
        
        // Carrega os itens do pedido e seus produtos (Gift Cards) relacionados para evitar N+1
        $order->load('items.giftCard'); // Ajuste 'product' para 'giftCard' se esse for o nome do seu relacionamento
                                         // Se o relacionamento no OrderItem for public function product(), mantenha 'items.product'
        
        return view('orders.show', compact('order'));
    }
}
