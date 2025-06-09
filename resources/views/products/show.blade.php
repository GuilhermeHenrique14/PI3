@extends('layouts.app')

@section('title', $product->name . ' - TokenStore')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div style="background: var(--glass-bg); border-radius: 15px; padding: 20px; border: 1px solid var(--glass-border);">
                {{-- Lógica de imagem do código "novo" parece boa --}}
                @if ($product->image_url)
                    <img src="{{ $product->image_url }}" class="img-fluid rounded" alt="{{ $product->name }}" style="width: 100%; max-height: 500px; object-fit: contain;">
                @else
                    {{-- Usando a lógica de placeholder do seu código antigo como fallback --}}
                    <img src="{{ asset($product->image_path ? 'storage/' . $product->image_path : ($product->image ? $product->image : 'https://via.placeholder.com/600x400.png/0a0a1a/8a2be2?text=Sem+Imagem')) }}" class="img-fluid rounded" alt="{{ $product->name }}" style="width: 100%; max-height: 500px; object-fit: cover;">
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div style="background: var(--glass-bg); border-radius: 15px; padding: 30px; border: 1px solid var(--glass-border); height: 100%;">
                {{-- Título, preço, badges e descrição - usando a estrutura do seu código antigo que parecia mais detalhada --}}
                <h1 class="mb-3" style="color: var(--primary-magenta); font-weight: 700; font-size: 2.2rem;">{{ $product->name }}</h1>
                <p class="mb-3" style="font-size: 1.8rem; font-weight: bold; color: var(--primary-cyan);">R$ {{ number_format($product->price, 2, ',', '.') }}</p>

                <div class="mb-3">
                    @if ($product->stock > 0)
                        <span class="badge me-2" style="background-color: var(--primary-cyan); color: var(--dark-bg); font-size: 0.9rem; padding: 0.5em 0.8em;">Em Estoque ({{$product->stock}})</span>
                    @else
                        <span class="badge me-2" style="background-color: #dc3545; color: white; font-size: 0.9rem; padding: 0.5em 0.8em;">Fora de Estoque</span>
                    @endif
                    @if ($product->category)
                        <span class="badge" style="background-color: var(--primary-purple); color: white; font-size: 0.9rem; padding: 0.5em 0.8em;">{{ $product->category->name }}</span>
                    @endif
                     @if ($product->is_featured)
                        <span class="badge ms-2" style="background-color: var(--primary-magenta); color: white; font-size: 0.9rem; padding: 0.5em 0.8em;"><i class="fas fa-star me-1"></i>Destaque</span>
                    @endif
                </div>

                <p class="mb-4" style="color: var(--text-secondary); line-height: 1.8;">{!! nl2br(e($product->description)) !!}</p>


                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: var(--primary-cyan-rgb-transparent); border-color: var(--primary-cyan); color: var(--text-primary);">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: rgba(var(--primary-magenta-rgb, 255, 0, 255), 0.3); border-color: var(--primary-magenta); color: var(--text-primary);">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm-{{ $product->id }}" class="mb-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" id="form_quantity_{{ $product->id }}" value="1"> {{-- Input oculto que o JS atualiza --}}

                        <div class="mb-3">
                            <label for="quantity_display_{{ $product->id }}" class="form-label" style="color: var(--text-secondary); font-weight: 500;">Quantidade:</label>
                            <div class="input-group" style="width: auto; max-width: 180px;">
                                {{-- Botões com estilo do código antigo, mas classes para o JS do código novo --}}
                                <button class="btn quantity-decrease" type="button" style="background-color: var(--primary-purple); color: white; border-color: var(--primary-purple); min-width: 38px;">-</button>
                                {{-- Input com estilo do código antigo para visibilidade --}}
                                <input type="number" id="quantity_display_{{ $product->id }}" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center no-spinners" aria-label="Quantidade" style="background-color: var(--glass-bg); color: var(--text-primary); border-color: var(--glass-border); font-weight: bold;">
                                <button class="btn quantity-increase" type="button" style="background-color: var(--primary-purple); color: white; border-color: var(--primary-purple); min-width: 38px;">+</button>
                            </div>
                            @if ($product->stock > 0 && $product->stock < 10)
                                <small class="form-text d-block mt-1" style="color: #ffc107;">Apenas {{ $product->stock }} unidade(s) restantes!</small>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg hero-cta" style="background: linear-gradient(135deg, var(--primary-magenta) 0%, var(--primary-purple) 100%); padding: 0.8rem 1.5rem; font-size: 1.1rem;">
                                <i class="fas fa-cart-plus me-2"></i>Adicionar ao Carrinho
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert mt-3" style="background-color: rgba(138, 43, 226,0.1); color: var(--primary-purple); border: 1px solid var(--primary-purple); border-left: 5px solid var(--primary-purple);">
                        <i class="fas fa-info-circle me-2"></i> Este produto está indisponível no momento.
                    </div>
                @endif

                {{-- Seção de informações de transação do código antigo --}}
                <div class="mt-4 p-3 rounded" style="background-color: var(--glass-bg); border: 1px solid var(--glass-border);">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-shield-alt me-2" style="color: var(--primary-cyan);"></i>
                        <span style="color: var(--text-secondary);">Transação segura</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-bolt me-2" style="color: var(--primary-magenta);"></i>
                        <span style="color: var(--text-secondary);">Entrega instantânea no seu e-mail</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-undo-alt me-2" style="color: #ff6b6b;"></i>
                        <span style="color: var(--text-secondary);">Sem reembolso para itens digitais</span>
                    </div>
                </div>

                {{-- Botão voltar para produtos (do código novo) --}}
                 <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-light" style="border-color: var(--primary-cyan); color: var(--primary-cyan); background-color: transparent;"
                       onmouseover="this.style.backgroundColor='var(--primary-cyan)'; this.style.color='var(--dark-bg)';"
                       onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--primary-cyan)';">
                        <i class="fas fa-arrow-left me-2"></i> Voltar para Produtos
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Produtos Relacionados (do código antigo) --}}
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="mt-5 pt-4" style="border-top: 1px solid var(--glass-border);">
        <h2 class="section-title mb-4">Produtos Relacionados</h2>
        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 game-card" style="background: var(--glass-bg); border-color: var(--glass-border);">
                        <a href="{{ route('products.show', $relatedProduct->slug ?? $relatedProduct->id) }}">
                            <img src="{{ asset($relatedProduct->image_path ? 'storage/' . $relatedProduct->image_path : ($relatedProduct->image ? $relatedProduct->image : 'https://via.placeholder.com/300x200.png/0a0a1a/8a2be2?text=Sem+Imagem')) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 180px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title game-title" style="color: var(--primary-magenta);"><a href="{{ route('products.show', $relatedProduct->slug ?? $relatedProduct->id) }}" class="text-decoration-none" style="color: inherit;">{{ $relatedProduct->name }}</a></h5>
                            <p class="game-price mb-auto" style="color: var(--primary-cyan); font-weight: bold;">R$ {{ number_format($relatedProduct->price, 2, ',', '.') }}</p>
                            <a href="{{ route('products.show', $relatedProduct->slug ?? $relatedProduct->id) }}" class="btn btn-sm mt-2" style="background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-cyan) 100%); color: white; border:0;">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    /* Esconde as setas padrão do input type="number" no Chrome, Safari, Edge, Opera */
    input[type=number].no-spinners::-webkit-outer-spin-button,
    input[type=number].no-spinners::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    /* Esconde as setas padrão do input type="number" no Firefox */
    input[type=number].no-spinners {
        -moz-appearance: textfield; /* Necessário para Firefox */
        appearance: textfield; /* Padrão */
    }
    .alert-success .btn-close,
    .alert-danger .btn-close {
        filter: brightness(0.8) invert(0.2);
    }
    /* Para garantir que os botões +/- não causem overflow no input-group em telas menores (do código antigo) */
    .input-group .btn {
        min-width: 38px; /* Ajuste conforme necessário */
    }
</style>
@endpush

@push('scripts')
{{-- Usando o JavaScript do "novo" código, pois ele atualiza o input oculto do formulário --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quantityDisplays = document.querySelectorAll('input[id^="quantity_display_"]');

    quantityDisplays.forEach(function(quantityDisplay) {
        const productId = quantityDisplay.id.split('_').pop();
        const formQuantityInput = document.getElementById('form_quantity_' + productId);
        // O seletor abaixo precisa encontrar os botões com as classes .quantity-decrease e .quantity-increase
        // que agora estão diretamente nos botões.
        const decreaseButton = quantityDisplay.closest('.input-group').querySelector('.quantity-decrease');
        const increaseButton = quantityDisplay.closest('.input-group').querySelector('.quantity-increase');
        const stock = parseInt(quantityDisplay.getAttribute('max')) || Infinity;

        if (!formQuantityInput) {
            console.error('Input de formulário oculto não encontrado para o produto ID:', productId);
            return;
        }
        if (!decreaseButton) {
            console.error('Botão decrease não encontrado para o produto ID:', productId);
        }
        if (!increaseButton) {
            console.error('Botão increase não encontrado para o produto ID:', productId);
        }


        function updateFormQuantity() {
            let currentValue = parseInt(quantityDisplay.value);
            if (isNaN(currentValue) || currentValue < 1) {
                currentValue = 1;
            } else if (currentValue > stock) {
                currentValue = stock;
            }
            quantityDisplay.value = currentValue;
            formQuantityInput.value = currentValue;
        }

        if (decreaseButton) {
            decreaseButton.addEventListener('click', function () {
                let currentValue = parseInt(quantityDisplay.value);
                if (currentValue > 1) {
                    quantityDisplay.value = currentValue - 1;
                    updateFormQuantity();
                }
            });
        }

        if (increaseButton) {
            increaseButton.addEventListener('click', function () {
                let currentValue = parseInt(quantityDisplay.value);
                if (currentValue < stock) {
                    quantityDisplay.value = currentValue + 1;
                    updateFormQuantity();
                }
            });
        }

        quantityDisplay.addEventListener('change', updateFormQuantity);
        quantityDisplay.addEventListener('input', updateFormQuantity);

        updateFormQuantity(); // Inicializa
    });
});
</script>
@endpush