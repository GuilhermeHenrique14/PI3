@extends('layouts.app')

@section('title', 'Finalizar Compra - TokenStore')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 class="section-title" style="font-size: 2.5rem; color: var(--primary-cyan);">Finalizar Compra</h1>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: rgba(var(--primary-magenta-rgb, 255, 0, 255), 0.3); border-color: var(--primary-magenta); color: var(--text-primary);">
            <strong>Opa!</strong> Algo deu errado:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
        @csrf
        <div class="row">
            {{-- Coluna Detalhes do Pagamento --}}
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="checkout-section" style="background: var(--glass-bg); border-radius: 15px; padding: 25px; border: 1px solid var(--glass-border);">
                    <h3 class="section-subtitle mb-4" style="color: var(--primary-cyan); border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">
                        <i class="fas fa-user-circle me-2"></i>Detalhes de Cobrança
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control form-control-lg checkout-input" id="name" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-lg checkout-input" id="email" value="{{ Auth::user()->email }}" readonly>
                        </div>
                    </div>

                    <hr class="my-4" style="border-color: var(--glass-border);">

                    <h4 class="section-subtitle mb-3" style="color: var(--primary-cyan);">
                        <i class="fas fa-credit-card me-2"></i>Método de Pagamento
                    </h4>
                    <div class="payment-method-option form-check mb-3 p-3" style="border: 1px solid var(--glass-border); border-radius: 8px;">
                        <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                        <label class="form-check-label ms-2" for="credit_card">
                            <i class="fab fa-cc-visa fa-fw me-2" style="color: var(--primary-blue, #007bff);"></i>Cartão de Crédito (Simulado)
                        </label>
                    </div>
                    <div class="payment-method-option form-check mb-3 p-3" style="border: 1px solid var(--glass-border); border-radius: 8px;">
                        <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                        <label class="form-check-label ms-2" for="paypal">
                            <i class="fab fa-paypal fa-fw me-2" style="color: #003087;"></i>PayPal (Simulado)
                        </label>
                    </div>
                    
                    <div id="credit-card-details" class="mt-3">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="card_number" class="form-label">Número do Cartão (fictício)</label>
                                <input type="text" class="form-control form-control-lg checkout-input" name="card_number" id="card_number" placeholder="xxxx xxxx xxxx xxxx" value="1234 5678 9012 3456">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expiration" class="form-label">Validade (MM/AA)</label>
                                <input type="text" class="form-control form-control-lg checkout-input" name="expiration" id="expiration" placeholder="12/25" value="12/25">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control form-control-lg checkout-input" name="cvv" id="cvv" placeholder="123" value="123">
                            </div>
                        </div>
                    </div>

                    <div class="form-check mt-4 mb-3">
                        <input class="form-check-input" type="checkbox" name="agree_terms" id="agree-terms" value="1" required>
                        {{-- Adicionando ms-2 para um pequeno espaçamento entre o checkbox e o label --}}
                        <label class="form-check-label ms-2" for="agree-terms">
                            Eu concordo com os <a href="#" style="color: var(--primary-magenta);">termos e condições</a> e <a href="#" style="color: var(--primary-magenta);">política de privacidade</a>.
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5">
                <div class="checkout-section sticky-top" style="background: var(--dark-secondary, #2a2a3a); border-radius: 15px; padding: 25px; border: 1px solid var(--glass-border); top: 20px;">
                    <h3 class="section-subtitle mb-4" style="color: var(--primary-cyan); border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">
                        <i class="fas fa-shopping-bag me-2"></i>Resumo do Pedido
                    </h3>
                    
                    @if($cart && $cart->items->isNotEmpty())
                        @foreach($cart->items as $item)
                            @if($item->product)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px dashed var(--glass-border-light, #444); {{ $loop->last ? 'border-bottom: none; margin-bottom: 0; padding-bottom: 0;' : '' }}">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item->product->image_url ?? asset('images/products/default_product.png') }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; margin-right: 15px; border: 1px solid var(--glass-border-light);">
                                    <div>
                                        <span class="fw-bold" style="color: var(--text-primary);">{{ $item->product->name }}</span><br>
                                        <small style="color: var(--text-secondary);">Qtd: {{ $item->quantity }}</small>
                                    </div>
                                </div>
                                <span class="fw-bold" style="color: var(--text-primary);">R$ {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}</span>
                            </div>
                            @endif
                        @endforeach
                    
                        <hr style="border-color: var(--glass-border); margin-top: 1rem; margin-bottom: 1rem;">
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: var(--text-secondary);">Subtotal:</span>
                            <span style="color: var(--text-primary);">R$ {{ number_format($cart->total(), 2, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: var(--text-secondary);">Taxas:</span>
                            <span style="color: var(--text-primary);">R$ 0,00</span>
                        </div>
                        <hr style="border-color: var(--glass-border); margin-top: 1rem; margin-bottom: 1rem;">
                        <div class="d-flex justify-content-between fw-bold mb-4">
                            <span style="font-size: 1.2rem; color: var(--text-primary);">Total:</span>
                            <span style="font-size: 1.2rem; color: var(--primary-cyan);">R$ {{ number_format($cart->total(), 2, ',', '.') }}</span>
                        </div>
                    @else
                        <p style="color: var(--text-secondary);">Seu carrinho está vazio.</p>
                    @endif
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" form="checkout-form" class="btn hero-cta btn-lg w-100" {{ (!$cart || $cart->items->isEmpty()) ? 'disabled' : '' }}>
                            <i class="fas fa-lock me-2"></i>Completar Pedido
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-light w-100" style="border-color: var(--primary-purple); color: var(--primary-purple); background-color: transparent;"
                           onmouseover="this.style.backgroundColor='rgba(var(--primary-purple-rgb), 0.2)';"
                           onmouseout="this.style.backgroundColor='transparent';">
                            <i class="fas fa-arrow-left me-2"></i>Voltar ao Carrinho
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        color: var(--text-secondary);
        margin-bottom: 0.3rem;
        font-size: 0.9rem;
    }

    .checkout-input,
    .form-control-lg.checkout-input {
        background-color: var(--dark-input-bg, #1e1e2d) !important;
        color: var(--text-primary, #e0e0e0) !important;
        border: 1px solid var(--glass-border, #444) !important;
        border-radius: 8px;
        padding: 0.75rem 1rem;
    }
    .checkout-input::placeholder {
        color: var(--text-placeholder, #6c757d);
    }
    .checkout-input:focus {
        background-color: var(--dark-input-bg-focus, #2a2a3a) !important;
        border-color: var(--primary-cyan, #00ffff) !important;
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-cyan-rgb, 0, 255, 255), 0.25);
    }
    .checkout-input[readonly] {
        background-color: var(--dark-input-bg-readonly, #252535) !important;
        opacity: 0.8;
    }

    .payment-method-option {
        transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
        cursor: pointer;
    }
    .payment-method-option:hover {
        background-color: rgba(var(--primary-cyan-rgb, 0, 255, 255), 0.1);
    }
    .payment-method-option input[type="radio"]:checked + label {
        color: var(--primary-cyan);
        font-weight: bold;
    }
    .payment-method-option input[type="radio"] {
        transform: scale(1.2);
        margin-top: 0.2rem; /* Ajuste vertical para os radios */
    }

    /* --- INÍCIO DAS MUDANÇAS PARA O CHECKBOX DE TERMOS (OPÇÃO 1) --- */
    .form-check-input { /* Estilo geral para todos os form-check-inputs, incluindo os radios */
        background-color: var(--dark-input-bg, #1e1e2d); /* Fundo padrão para checkboxes/radios não marcados */
        border: 1px solid var(--primary-purple, #8a2be2); /* Borda padrão visível */
        /* Os tamanhos e margin-top dos radios são definidos em .payment-method-option input[type="radio"] */
    }

    .form-check-input#agree-terms { /* Estilos específicos para o checkbox de termos */
        width: 1.15em; /* Um pouco maior para destaque */
        height: 1.15em;
        margin-top: 0.2em; /* Ajuste vertical se necessário para alinhar com o label */
        /* Herda background-color e border de .form-check-input geral se não especificado aqui */
    }

    .form-check-input:focus { /* Estilo de foco para todos os form-check-inputs */
        border-color: var(--primary-cyan, #00ffff);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-cyan-rgb, 0, 255, 255), 0.25);
        outline: 0; /* Remove o outline padrão do navegador no foco, já que temos box-shadow */
    }

    .form-check-input:checked { /* Estilo quando marcado, aplica-se a radios e checkboxes */
        background-color: var(--primary-cyan, #00ffff);
        border-color: var(--primary-cyan, #00ffff);
    }

    /* Estilo para o label do checkbox de termos para melhor contraste do texto */
    #agree-terms + .form-check-label {
        color: var(--text-primary, #e0e0e0); /* Garante que o texto do label seja claro */
        padding-left: 0.25rem; /* Pequeno ajuste para não colar no checkbox */
    }

    #agree-terms + .form-check-label a {
        color: var(--primary-magenta, #ff00ff); /* Mantém a cor dos links */
        text-decoration: none;
    }
    #agree-terms + .form-check-label a:hover {
        text-decoration: underline;
    }
    /* --- FIM DAS MUDANÇAS PARA O CHECKBOX DE TERMOS (OPÇÃO 1) --- */


    .hero-cta {
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
    }
    .hero-cta:disabled {
        background: var(--bs-secondary); /* Use uma variável Bootstrap ou defina a sua */
        border-color: var(--bs-secondary);
        opacity: 0.65;
        cursor: not-allowed;
    }

    .section-subtitle {
        font-weight: 600;
    }

    @media (min-width: 992px) {
        .sticky-top {
            position: -webkit-sticky;
            position: sticky;
            top: 80px;
            z-index: 1020;
        }
    }
</style>
@endpush