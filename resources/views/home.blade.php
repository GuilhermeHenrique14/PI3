@extends('layouts.app')

@section('title', 'TokenStore - Gift Cards e Jogos Digitais')

@section('content')

{{-- CARROSSEL, BOAS-VINDAS, CATEGORIAS (permanecem como no seu código anterior que funcionava) --}}
@if(isset($carouselSlides) && count($carouselSlides) > 0)
<div id="mainCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-indicators">
        @foreach($carouselSlides as $index => $slide)
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($carouselSlides as $slide)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
            <img src="{{ asset($slide['image']) }}" class="d-block w-100 carousel-image-custom" alt="{{ $slide['alt_text'] ?? 'Banner TokenStore' }}">
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>
@endif

<section class="welcome-section text-center py-4 mb-5">
    <div class="container">
        <h2 class="welcome-title mb-3">Bem-vindo à TokenStore!</h2>
        <p class="lead welcome-subtitle">Sua parada obrigatória para os melhores gift cards e jogos digitais.</p>
    </div>
</section>

<div class="container">
    @if(isset($featuredCategories) && $featuredCategories->isNotEmpty())
    <section class="featured-categories mb-5">
        <h2 class="text-center mb-4 section-title">Nossas Categorias</h2>
        <div class="row">
            @foreach($featuredCategories as $category)
            <div class="col-lg-3 col-md-6 col-6 mb-4">
                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                   class="category-card-link text-decoration-none">
                    <div class="card category-card-bg text-white h-100 shadow-sm"
                         style="background-image: url('{{ asset($category->icon_image ?? 'images/categories/default_category_icon.png') }}');">
                        <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center p-3">
                            <h5 class="card-title category-name-on-bg text-center">{{ $category->name }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- PRODUTOS POPULARES - HTML ATUALIZADO --}}
    @if(isset($popularProducts) && $popularProducts->isNotEmpty())
    <section class="popular-products mb-5">
        <h2 class="text-center mb-4 section-title">Produtos Populares</h2>
        {{-- Adicionando a classe .games-grid para consistência com products/index.blade.php --}}
        <div class="row games-grid g-4">
            @foreach($popularProducts as $product)
            {{-- Estrutura da coluna igual à de products/index.blade.php --}}
            <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-flex align-items-stretch">
                {{--
                    Aqui idealmente você usaria o mesmo partial:
                    @include('partials.product_card', ['product' => $product])

                    Mas, se você não tem o partial `product_card.blade.php` ou quer
                    colocar o HTML diretamente por enquanto, adaptamos o HTML
                    para usar as classes `.game-card`, `.game-image`, etc.
                --}}
                <div class="game-card"> {{-- Usando a classe .game-card --}}
                    <a href="{{ route('products.show', $product->slug) }}" class="game-image-link">
                        <div class="game-image">
                        <img src="{{ $product->image_url ?? asset('images/products/default_product.png') }}" alt="{{ $product->name }}">                                 alt="{{ $product->name }}">
                        </div>
                    </a>
                    <div class="card-body"> {{-- O CSS da página de produtos usa .game-card .card-body --}}
                        <h5 class="game-title">
                            <a href="{{ route('products.show', $product->slug) }}">{{ Str::limit($product->name, 40) }}</a>
                        </h5>
                        @if($product->category)
                        <p class="game-category small mb-2">
                            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                        </p>
                        @endif
                        <p class="game-price mb-auto">
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        </p>
                        {{-- O botão agora usa as classes e estilo do game-card --}}
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-add-to-cart mt-2">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4"> {{-- Ajustado o margin-top --}}
            <a href="{{ route('products.index') }}" class="btn btn-lg btn-outline-secondary">Ver Todos os Produtos</a>
        </div>
    </section>
    @endif
</div>

<footer class="bg-dark text-light mt-auto py-4">
    <div class="container text-center">
        <p class="mb-1">&copy; {{ date('Y') }} TokenStore. Todos os direitos reservados.</p>
        <p class="mb-0 small">
            <a href="#" class="text-light text-decoration-none">Sobre Nós</a> |
            <a href="#" class="text-light text-decoration-none">Contato</a> |
            <a href="#" class="text-light text-decoration-none">Política de Privacidade</a>
        </p>
    </div>
</footer>

@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f6f9;
    }
    .section-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #333;
        margin-bottom: 2.5rem !important;
    }

    .carousel-image-custom {
        max-height: 550px;
        object-fit: cover;
        width: 100%;
    }

    .welcome-section {
        background: linear-gradient(135deg, #16213E, #0F3460);
        color: #ffffff;
    }
    .welcome-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 2.8rem;
        background: -webkit-linear-gradient(45deg, #8A2BE2, #FF69B4, #00FFFF);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #FF69B4;
        margin-bottom: 0.75rem !important;
    }
    .welcome-subtitle {
        font-family: 'Roboto', sans-serif;
        color: #e0e0e0;
        font-size: 1.25rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .category-card-link { display: block; height: 100%; border-radius: 0.375rem; overflow: hidden; transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; }
    .category-card-link:hover { transform: translateY(-5px) scale(1.03); box-shadow: 0 12px 25px rgba(0,0,0,0.15); }
    .category-card-bg { background-size: cover; background-position: center center; background-repeat: no-repeat; min-height: 200px; border: none; position: relative; }
    .category-card-bg::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.50); z-index: 1; border-radius: inherit; transition: background-color 0.3s ease; }
    .category-card-link:hover .category-card-bg::before { background-color: rgba(0, 0, 0, 0.35); }
    .category-card-bg .card-img-overlay { position: relative; z-index: 2; background: none; display: flex; flex-direction: column; justify-content: center; align-items: center; }
    .category-name-on-bg { font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 700; color: #ffffff; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7); }

    /* === ESTILOS DOS CARDS DE PRODUTO (GAME-CARD) - Copiados de products/index.blade.php === */
    .games-grid .game-card { background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 0.5rem; overflow: hidden; display: flex; flex-direction: column; height: 100%; transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
    .games-grid .game-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(var(--primary-purple-rgb, 138, 43, 226), 0.25), 0 0 0 2px var(--primary-cyan); }
    .game-card .game-image-link { display: block; }
    .game-card .game-image { width: 100%; aspect-ratio: 4 / 3; height: auto !important; overflow: hidden; background: linear-gradient(135deg, rgba(var(--primary-purple-rgb, 138, 43, 226), 0.1) 0%, rgba(var(--primary-cyan-rgb, 0, 255, 255), 0.1) 100%); position: relative; display: block; }
    .game-card .game-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
    /* Removendo badges por enquanto, pois não estão no HTML da home original */
    /* .game-card .badge { font-size: 0.75rem; padding: 0.3em 0.6em; } */
    /* .game-card .badge-featured { background-color: var(--primary-magenta); color: white; } */
    /* .game-card .badge-unavailable { background-color: #6c757d; color: white; } */
    /* .game-card .badge-low-stock { background-color: #ffc107; color: #212529; } */
    .game-card .card-body { display: flex; flex-direction: column; flex-grow: 1; padding: 0.8rem 1rem; }
    .game-card .game-title a { font-size: 0.95rem; font-weight: 600; color: var(--primary-magenta); text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: calc(0.95rem * 1.4 * 2); line-height: 1.4; }
    .game-card .game-title a:hover { color: var(--primary-cyan); }
    .game-card .game-category a { font-size: 0.75rem; color: var(--text-secondary); text-decoration: none; }
    .game-card .game-category a:hover { color: var(--primary-magenta); }
    .game-card .game-price { color: var(--primary-cyan); font-size: 1.1rem; font-weight: bold; margin-top: 0.5rem; margin-bottom: 0.75rem; }
    .game-card .btn-add-to-cart,
    .game-card .btn-secondary[disabled] { background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-cyan) 100%); color: white; border:0; font-weight: 500; padding: 0.5rem 0.75rem; font-size: 0.85rem; width: 100%; text-align: center; }
    .game-card .btn-add-to-cart:hover { opacity: 0.9; }
    /* .game-card .btn-secondary[disabled] { background: #6c757d; opacity: 0.65; cursor: not-allowed; } */
    /* Não precisamos dos estilos de paginação aqui na home */

    .footer a { transition: color 0.2s ease-in-out; }
    .footer a:hover { color: #FF69B4 !important; }
</style>
@endpush

@push('scripts')
<script>
    // document.addEventListener('DOMContentLoaded', function () {
    // });
</script>
@endpush