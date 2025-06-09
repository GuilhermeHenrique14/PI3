@extends('layouts.app')

@section('title', 'TokenStore - Gift Cards e Jogos Digitais')

@section('content')

{{-- SEU HTML DO CARROSSEL (COMO NA RESPOSTA ANTERIOR, COM O carousel-caption) --}}
@if(isset($carouselSlides) && count($carouselSlides) > 0)
<div class="container-fluid p-0 main-carousel-wrapper">
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            @foreach($carouselSlides as $index => $slide)
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($carouselSlides as $slide)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img src="{{ asset($slide['image']) }}" class="d-block w-100 carousel-image-adjusted" alt="{{ $slide['alt_text'] ?? 'Banner TokenStore' }}">
                @if(isset($slide['title']) || isset($slide['subtitle']))
                {{-- Removido text-start daqui para que o text-align: center do CSS funcione --}}
                <div class="carousel-caption d-none d-md-block poppins-caption"> 
                    @if(isset($slide['title']))
                        <h2 class="carousel-title">{{ $slide['title'] }}</h2>
                    @endif
                    @if(isset($slide['subtitle']))
                        <p class="carousel-subtitle lead">{{ $slide['subtitle'] }}</p>
                    @endif
                    {{-- <a href="#" class="btn btn-lg btn-primary mt-3">Ver Ofertas</a> --}}
                </div>
                @endif
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
</div>
@endif
{{-- Fim do Carrossel --}}


{{-- RESTANTE DO SEU CONTEÚDO DA HOME.BLADE.PHP (welcome-section, categories, products) --}}
{{-- ... (seu código para welcome, categories, products como na resposta anterior) ... --}}
<section class="welcome-section text-center py-4 mb-5 mt-custom-spacing">
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
                         style="background-image: url('{{ $category->icon_image }}');">
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

    @if(isset($popularProducts) && $popularProducts->isNotEmpty())
    <section class="popular-products mb-5">
        <h2 class="text-center mb-4 section-title">Produtos Populares</h2>
        <div class="row games-grid g-4">
            @foreach($popularProducts as $product)
            <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-flex align-items-stretch">
                <div class="game-card">
                    <a href="{{ route('products.show', $product->slug) }}" class="game-image-link">
                        <div class="game-image">
                        <img src="{{ $product->image_url ?? asset('images/products/default_product.png') }}" alt="{{ $product->name }}">
                        </div>
                    </a>
                    <div class="card-body">
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
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-add-to-cart mt-2">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-lg btn-outline-secondary">Ver Todos os Produtos</a>
        </div>
    </section>

    {{-- Seção de Frete Grátis (conforme imagem) --}}
    <section class="free-shipping-section">
        <div class="free-shipping-item">
            <i class="fas fa-truck"></i>
            <h4>Frete grátis</h4>
            <p>Receba o código por e-mail</p>
        </div>
        <div class="free-shipping-item">
            <i class="fas fa-hourglass-half"></i>
            <h4>Enviamos</h4>
            <p>Seu código em até 1 hora</p>
        </div>
        <div class="free-shipping-item">
            <i class="fas fa-coins"></i> {{-- Ícone de moedas ou similar para "Pague com Pix" --}}
            <h4>Pague com Pix</h4>
            <p>Receba seu código mais rápido!</p>
        </div>
        <div class="free-shipping-item">
            <i class="fas fa-shield-alt"></i>
            <h4>Segurança</h4>
            <p>Suas compras 100% protegidas</p>
        </div>
    </section>
    {{-- Fim da Seção de Frete Grátis --}}
    @endif
</div>
{{-- FIM DO RESTANTE DO CONTEÚDO --}}

@endsection

@push('styles')
{{-- Seu link para Google Fonts com Poppins --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Poppins:wght@400;500;600;700;900&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
    /* SEU CSS ORIGINAL DA HOME.BLADE.PHP (body, .section-title, .welcome-section, etc.) */
    /* ... (seu CSS original como na resposta anterior) ... */
    body { font-family: 'Roboto', sans-serif; }
    .section-title { font-family: 'Montserrat', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-primary, #333); margin-bottom: 2.5rem !important; }
    .welcome-section { color: var(--text-primary, #ffffff); }
    .welcome-title { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 2.8rem; background: -webkit-linear-gradient(45deg, #8A2BE2, #FF69B4, #00FFFF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; color: #FF69B4; margin-bottom: 0.75rem !important; }
    .welcome-subtitle { font-family: 'Roboto', sans-serif; color: var(--text-secondary, #e0e0e0); font-size: 1.25rem; max-width: 700px; margin-left: auto; margin-right: auto; }
    .category-card-link { display: block; height: 100%; border-radius: 0.375rem; overflow: hidden; transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; }
    .category-card-link:hover { transform: translateY(-5px) scale(1.03); box-shadow: 0 12px 25px rgba(0,0,0,0.15); }
    .category-card-bg { background-size: cover; background-position: center center; background-repeat: no-repeat; min-height: 200px; border: none; position: relative; }
    .category-card-bg::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.50); z-index: 1; border-radius: inherit; transition: background-color 0.3s ease; }
    .category-card-link:hover .category-card-bg::before { background-color: rgba(0, 0, 0, 0.35); }
    .category-card-bg .card-img-overlay { position: relative; z-index: 2; background: none; display: flex; flex-direction: column; justify-content: center; align-items: center; }
    .category-name-on-bg { font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 700; color: #ffffff; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7); }
    .games-grid .game-card { background: var(--glass-bg, rgba(255,255,255,0.05)); border: 1px solid var(--glass-border, rgba(255,255,255,0.1)); border-radius: 0.5rem; overflow: hidden; display: flex; flex-direction: column; height: 100%; transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
    .games-grid .game-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(var(--primary-purple-rgb, 138, 43, 226), 0.25), 0 0 0 2px var(--primary-cyan, #00ffff); }
    .game-card .game-image-link { display: block; }
    .game-card .game-image { width: 100%; aspect-ratio: 4 / 3; height: auto !important; overflow: hidden; background: linear-gradient(135deg, rgba(var(--primary-purple-rgb, 138, 43, 226), 0.1) 0%, rgba(var(--primary-cyan-rgb, 0, 255, 255), 0.1) 100%); position: relative; display: block; }
    .game-card .game-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .game-card .card-body { display: flex; flex-direction: column; flex-grow: 1; padding: 0.8rem 1rem; }
    .game-card .game-title a { font-size: 0.95rem; font-weight: 600; color: var(--primary-magenta, #ff00ff); text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: calc(0.95rem * 1.4 * 2); line-height: 1.4; }
    .game-card .game-title a:hover { color: var(--primary-cyan, #00ffff); }
    .game-card .game-category a { font-size: 0.75rem; color: var(--text-secondary, rgba(255,255,255,0.8)); text-decoration: none; }
    .game-card .game-category a:hover { color: var(--primary-magenta, #ff00ff); }
    .game-card .game-price { color: var(--primary-cyan, #00ffff); font-size: 1.1rem; font-weight: bold; margin-top: 0.5rem; margin-bottom: 0.75rem; }
    .game-card .btn-add-to-cart, .game-card .btn-secondary[disabled] { background: linear-gradient(135deg, var(--primary-purple, #8a2be2) 0%, var(--primary-cyan, #00ffff) 100%); color: white; border:0; font-weight: 500; padding: 0.5rem 0.75rem; font-size: 0.85rem; width: 100%; text-align: center; }
    .game-card .btn-add-to-cart:hover { opacity: 0.9; }
    /* FIM DO SEU CSS ORIGINAL */

    /* ESTILOS PARA O CARROSSEL E SEUS TEXTOS (ATUALIZADO) */
    .main-carousel-wrapper {
        /* margin-top: -20px; */ 
    }
    #mainCarousel .carousel-image-adjusted {
        width: 100%;
        max-height: 580px; 
        object-fit: cover;
    }
    .mt-custom-spacing {
        margin-top: 3rem; 
    }

    .poppins-caption {
        font-family: 'Poppins', sans-serif;
        /* Centralização e posicionamento */
        bottom: 12%; /* Um pouco mais para cima */
        left: 50%;
        transform: translateX(-50%);
        width: 65%; /* Largura da caixa de mensagem */
        max-width: 650px; /* Limite máximo da largura */
        padding: 1.5rem; /* Padding interno */
        border-radius: 0.75rem; /* Cantos arredondados como os cards */
        text-align: center; /* Centraliza o texto DENTRO da caixa */
        
        /* Estilo TokenStore para o fundo */
        background: var(--glass-bg, rgba(30, 10, 50, 0.25)); /* Usando sua variável --glass-bg ou um fallback mais escuro */
        backdrop-filter: blur(12px); /* Efeito de vidro */
        border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1)); /* Borda sutil de vidro */
        /* Opcional: uma sombra para destacar mais o card */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);

        color: var(--text-primary, #ffffff); /* Cor padrão do texto */
        text-shadow: none; /* Remover sombra preta genérica, vamos adicionar sombras específicas se necessário */
    }

    .poppins-caption .carousel-title {
        font-size: 2.2rem; /* Ajuste o tamanho conforme preferir */
        font-weight: 700; /* Poppins Bold */
        margin-bottom: 0.75rem;
        /* Cor do título com destaque TokenStore */
        color: var(--primary-cyan, #00ffff); /* Ciano como destaque */
        text-shadow: 1px 1px 3px rgba(var(--primary-purple-rgb, 138, 43, 226), 0.5); /* Sombra roxa sutil */
    }

    .poppins-caption .carousel-subtitle {
        font-size: 1.05rem; /* Ajuste o tamanho */
        font-weight: 400; /* Poppins Regular */
        line-height: 1.6;
        color: var(--text-secondary, #e0e0e0); /* Cor mais suave */
        margin-bottom: 0;
    }

    /* Ajustes para telas menores */
    @media (max-width: 991.98px) {
        .poppins-caption {
            width: 75%;
            max-width: 550px;
            padding: 1.25rem;
            bottom: 10%;
        }
        .poppins-caption .carousel-title {
            font-size: 1.9rem;
        }
        .poppins-caption .carousel-subtitle {
            font-size: 1rem;
        }
    }
    @media (max-width: 767.98px) {
        /* O .carousel-caption tem d-none d-md-block, então não aparecerá aqui por padrão.
           Se você remover o d-none, pode precisar ajustar mais: */
        .poppins-caption {
            width: 85%;
            padding: 1rem;
            bottom: 8%;
        }
        .poppins-caption .carousel-title {
            font-size: 1.6rem;
        }
        .poppins-caption .carousel-subtitle {
            font-size: 0.9rem;
        }
    }

</style>
@endpush

@push('scripts')
<script>
    // Seu JS aqui
</script>
@endpush