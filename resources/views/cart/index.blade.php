@extends('layouts.app')

@section('title', 'Meu Carrinho - TokenStore')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 class="section-title" style="font-size: 2.5rem;">Meu Carrinho</h1>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: rgba(var(--primary-cyan-rgb, 0, 255, 255), 0.2); border-color: var(--primary-cyan); color: var(--text-primary);">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: rgba(var(--primary-magenta-rgb, 255, 0, 255), 0.2); border-color: var(--primary-magenta); color: var(--text-primary);">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert" style="background-color: rgba(var(--primary-purple-rgb, 138, 43, 226), 0.2); border-color: var(--primary-purple); color: var(--text-primary);">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div id="cart-content-container">
        @if ($cartItems && count($cartItems) > 0)
            <div class="row">
                <div class="col-lg-8">
                    <div class="lista-itens-carrinho" style="background: var(--glass-bg); border-radius: 15px; padding: 20px; border: 1px solid var(--glass-border); margin-bottom: 2rem;">
                        @foreach ($cartItems as $item)
                            @php
                                $productExists = $item->product;
                                $productName = $productExists ? $item->product->name : 'Produto Indisponível';
                                $productImage = $productExists ? ($item->product->image_url ?? asset('images/products/default_product.png')) : asset('images/products/default_product.png');
                                $productPrice = $productExists ? $item->product->price : 0;
                                $itemTotal = $productPrice * $item->quantity;
                                $productSlug = $productExists ? $item->product->slug : null; // Pega o slug se o produto existir
                            @endphp
                            <div class="item-carrinho d-flex align-items-center p-3 mb-3 cart-item-row" data-product-id="{{ $item->product_id }}" style="border-bottom: 1px solid var(--glass-border);">
                                
                                {{-- IMAGEM CLICÁVEL --}}
                                @if ($productExists && $productSlug)
                                    <a href="{{ route('products.show', ['product' => $productSlug]) }}" title="Ver detalhes de {{ $productName }}">
                                        <img src="{{ $productImage }}" alt="{{ $productName }}" class="img-fluid me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                    </a>
                                @else
                                    <img src="{{ $productImage }}" alt="{{ $productName }}" class="img-fluid me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                @endif

                                <div class="detalhes-item flex-grow-1">
                                    {{-- NOME DO PRODUTO CLICÁVEL --}}
                                    @if ($productExists && $productSlug)
                                        <a href="{{ route('products.show', ['product' => $productSlug]) }}" style="text-decoration: none;" title="Ver detalhes de {{ $productName }}">
                                            <h5 style="color: var(--primary-magenta); margin-bottom: 0.25rem; display: inline-block;">{{ $productName }}</h5>
                                        </a>
                                    @else
                                        <h5 style="color: var(--primary-magenta); margin-bottom: 0.25rem;">{{ $productName }}</h5>
                                    @endif

                                    @if($productExists)
                                        <p class="preco-unitario-item mb-1" style="font-size: 0.9rem; color: var(--text-secondary);">R$ {{ number_format($productPrice, 2, ',', '.') }}</p>
                                    @else
                                        <p class="mb-1" style="font-size: 0.9rem; color: var(--bs-danger);">Produto removido</p>
                                    @endif
                                </div>
                                
                                @if($productExists)
                                <div class="quantidade-item d-flex align-items-center mx-3">
                                    <button type="button" class="btn btn-sm btn-decrement" data-id="{{ $item->product_id }}" style="background: var(--primary-purple); color: white; border-radius: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">-</button>
                                    <input type="text" value="{{ $item->quantity }}" readonly class="form-control form-control-sm text-center mx-2 item-quantity no-spinners" data-id="{{ $item->product_id }}" style="width: 60px; background-color: var(--dark-secondary); color: var(--text-primary); border-color: var(--glass-border);">
                                    <button type="button" class="btn btn-sm btn-increment" data-id="{{ $item->product_id }}" style="background: var(--primary-purple); color: white; border-radius: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">+</button>
                                </div>
                                <p class="preco-total-item fw-bold mx-3 item-subtotal" style="min-width: 100px; text-align: right; color: var(--text-primary);">R$ {{ number_format($itemTotal, 2, ',', '.') }}</p>
                                @else
                                <div class="quantidade-item d-flex align-items-center mx-3" style="min-width: 150px;"></div>
                                <p class="preco-total-item fw-bold mx-3" style="min-width: 100px; text-align: right; color: var(--text-primary);">-</p>
                                @endif
                                
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="remove-item-form-traditional">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0" style="color: var(--primary-magenta); font-size: 1.2rem;" title="Remover item">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                        @if($cart && $cart->items()->count() > 0)
                            <div class="d-flex justify-content-end mt-3">
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background-color: var(--primary-magenta); color:white; border-color: var(--primary-magenta);" onclick="return confirm('Tem certeza que deseja esvaziar o carrinho?')">
                                        <i class="fas fa-times-circle me-1"></i> Esvaziar Carrinho
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="resumo-carrinho p-4" style="background: var(--dark-secondary); border-radius: 15px; border: 1px solid var(--glass-border);">
                        <h3 style="color: var(--primary-cyan); border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; margin-bottom: 20px;">Resumo do Pedido</h3>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: var(--text-secondary);">Subtotal:</span>
                            <span class="valor-subtotal fw-bold" id="cart-subtotal-summary" style="color: var(--text-primary);">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                        <hr style="border-color: var(--glass-border); margin-top: 1rem; margin-bottom: 1rem;">
                        <div class="d-flex justify-content-between fw-bold mb-4">
                            <span style="font-size: 1.2rem; color: var(--text-primary);">Total:</span>
                            <span class="valor-total-geral" id="cart-total-summary" style="font-size: 1.2rem; color: var(--primary-cyan);">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn hero-cta w-100 mb-2" style="padding: 0.75rem 1.5rem; font-size: 1rem;">
                            <i class="fas fa-credit-card me-2"></i> Ir para Pagamento
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-light w-100" style="border-color: var(--primary-cyan); color: var(--primary-cyan); background-color: transparent;"
                           onmouseover="this.style.backgroundColor='var(--primary-cyan)'; this.style.color='var(--dark-bg)';"
                           onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--primary-cyan)';">
                            <i class="fas fa-shopping-bag me-2"></i> Continuar Comprando
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div id="empty-cart-message-container" class="row" style="display: {{ ($cartItems && count($cartItems) > 0) ? 'none' : 'block' }};">
        <div class="col-12">
            <div class="text-center p-5" style="background: var(--glass-bg); border-radius: 15px; border: 1px solid var(--glass-border);">
                <i class="fas fa-shopping-cart fa-4x mb-4" style="color: var(--primary-purple);"></i>
                <h2 style="color: var(--primary-cyan);">Seu carrinho está vazio!</h2>
                <p style="color: var(--text-secondary);">Adicione alguns produtos para vê-los aqui.</p>
                <a href="{{ route('products.index') }}" class="btn hero-cta mt-3">
                    <i class="fas fa-gamepad me-1"></i> Ver Produtos
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    input[type=number].no-spinners::-webkit-outer-spin-button,
    input[type=number].no-spinners::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number].no-spinners {
        -moz-appearance: textfield;
    }
    .alert-success .btn-close,
    .alert-danger .btn-close,
    .alert-info .btn-close {
        filter: brightness(0.9) invert(0.1);
    }
    .btn-decrement.loading, .btn-increment.loading {
        pointer-events: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenEl) {
        console.error('CSRF token not found!');
        return;
    }
    const csrfToken = csrfTokenEl.getAttribute('content');

    const cartContentContainer = document.getElementById('cart-content-container');
    const emptyCartMessageContainer = document.getElementById('empty-cart-message-container');

    function updateCartTotals(cartTotalFormatted, cartItemCount) {
        const cartSubtotalSummaryEl = document.getElementById('cart-subtotal-summary');
        const cartTotalSummaryEl = document.getElementById('cart-total-summary');
        const cartItemCountBadgeEl = document.getElementById('cart-item-count-badge');

        if (cartSubtotalSummaryEl) cartSubtotalSummaryEl.textContent = 'R$ ' + cartTotalFormatted;
        if (cartTotalSummaryEl) cartTotalSummaryEl.textContent = 'R$ ' + cartTotalFormatted;

        if (cartItemCountBadgeEl) {
            cartItemCountBadgeEl.textContent = cartItemCount;
            cartItemCountBadgeEl.style.display = cartItemCount > 0 ? 'inline-block' : 'none';
        }

        if (cartItemCount === 0) {
            if (cartContentContainer) cartContentContainer.style.display = 'none';
            if (emptyCartMessageContainer) emptyCartMessageContainer.style.display = 'block';
        } else {
            if (cartContentContainer) cartContentContainer.style.display = 'block';
            if (emptyCartMessageContainer) emptyCartMessageContainer.style.display = 'none';
        }
    }

    document.querySelectorAll('.btn-increment, .btn-decrement').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.id;
            const row = this.closest('.cart-item-row');
            if (!row) {
                console.error('Cart item row not found for product ID:', productId);
                return;
            }
            const quantityInput = row.querySelector('.item-quantity');
            if (!quantityInput) {
                console.error('Quantity input not found for product ID:', productId);
                return;
            }

            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity;

            if (this.classList.contains('btn-increment')) {
                newQuantity++;
            } else if (this.classList.contains('btn-decrement')) {
                newQuantity--;
            }

            if (newQuantity < 0) newQuantity = 0;

            row.style.opacity = '0.7';
            this.classList.add('loading');
            this.disabled = true;
            const siblingButton = this.classList.contains('btn-increment') ?
                                  this.previousElementSibling.previousElementSibling :
                                  this.nextElementSibling.nextElementSibling;
            if(siblingButton) siblingButton.disabled = true;

            fetch('{{ route("cart.update.quantity.ajax") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: newQuantity
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errData => {
                        throw { status: response.status, data: errData };
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (data.removed) {
                        if (row) row.remove();
                    } else {
                        quantityInput.value = data.newQuantity;
                        const itemSubtotalEl = row.querySelector('.item-subtotal');
                        if (itemSubtotalEl) itemSubtotalEl.textContent = 'R$ ' + data.itemSubtotalFormatted;
                    }
                    updateCartTotals(data.cartTotalFormatted, data.cartItemCount);
                    if(data.message && (data.removed || newQuantity !== currentQuantity)) {
                         showFlashMessage(data.message, 'success');
                    }
                } else {
                    showFlashMessage(data.message || 'Erro ao atualizar a quantidade.', 'danger');
                    if (data.originalQuantity !== undefined) {
                        quantityInput.value = data.originalQuantity;
                    }
                }
            })
            .catch(error => {
                console.error('Error updating cart:', error);
                let errorMessage = 'Ocorreu um erro de comunicação. Por favor, tente novamente.';
                if(error.data && error.data.message) {
                    errorMessage = error.data.message;
                } else if (error.status) {
                    errorMessage = `Erro ${error.status}. Por favor, tente novamente.`;
                }
                showFlashMessage(errorMessage, 'danger');
                quantityInput.value = currentQuantity;
            })
            .finally(() => {
                row.style.opacity = '1';
                this.classList.remove('loading');
                this.disabled = false;
                if(siblingButton) siblingButton.disabled = false;
            });
        });
    });

    function showFlashMessage(message, type = 'info') {
        const existingAlert = document.querySelector('.dynamic-alert');
        if(existingAlert) existingAlert.remove();

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show dynamic-alert`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '1050';
        if (type === 'success') {
            alertDiv.style.backgroundColor = 'rgba(var(--primary-cyan-rgb, 0, 255, 255), 0.9)';
            alertDiv.style.borderColor = 'var(--primary-cyan)';
        } else if (type === 'danger') {
            alertDiv.style.backgroundColor = 'rgba(var(--primary-magenta-rgb, 255, 0, 255), 0.9)';
            alertDiv.style.borderColor = 'var(--primary-magenta)';
        }
        alertDiv.style.color = 'var(--text-primary)';

        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.body.appendChild(alertDiv);

        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getInstance(alertDiv);
            if (bsAlert) {
                bsAlert.close();
            } else if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
</script>
@endpush