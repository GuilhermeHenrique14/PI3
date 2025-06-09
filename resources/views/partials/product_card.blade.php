{{-- resources/views/partials/product_card.blade.php --}}
<div class="card h-100 game-card shadow-sm">
    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none d-block game-image-link">
        {{-- A div game-image voltará a ser estilizada pelo CSS no @push('styles') ou arquivo CSS principal --}}
        <div class="game-image position-relative">
            <img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->name }}">
            @if ($product->is_featured)
                <span class="badge position-absolute top-0 end-0 m-2 badge-featured"><i class="fas fa-star"></i></span>
            @endif
             @if ($product->stock == 0)
                <span class="badge position-absolute top-0 start-0 m-2 badge-unavailable">INDISPONÍVEL</span>
            @elseif ($product->stock < 10 && $product->stock > 0)
                <span class="badge position-absolute top-0 start-0 m-2 badge-low-stock">ÚLTIMAS UNIDADES</span>
            @endif
        </div>
    </a>
    <div class="card-body d-flex flex-column p-3">
        <h5 class="card-title game-title mb-1">
            <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                {{ $product->name }}
            </a>
        </h5>
        @if($product->category)
        <small class="text-muted mb-2 d-block game-category">
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-decoration-none">
                {{ $product->category->name }}
            </a>
        </small>
        @endif

        <p class="game-price fs-5 fw-bold my-2">R$ {{ number_format($product->price, 2, ',', '.') }}</p>

        <div style="flex-grow: 1;"></div>

        @if ($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="mt-auto d-grid">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-add-to-cart">
                    <i class="fas fa-cart-plus me-1"></i> Adicionar
                </button>
            </form>
        @else
            <button type="button" class="btn btn-secondary w-100 mt-auto" disabled>
                Indisponível
            </button>
        @endif
    </div>
</div>