@extends('layouts.app')

@section('title', $categoryName ? 'Produtos da Categoria: ' . $categoryName : 'Nossos Produtos - TokenStore')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="section-title" style="font-size: 3rem;">
                @if($categoryName)
                    {{ $categoryName }}
                @else
                    Nossos Produtos
                @endif
            </h1>

            {{-- Container para os botões de limpar filtros --}}
            <div class="active-filters-cointainer mt-2 mb-3">
                @php
                    $hasActiveFilters = false;
                @endphp

                @if($selectedCategorySlug)
                    @php
                        $hasActiveFilters = true;
                        $clearCategoryQueryParams = [];
                        if (request('sort_by')) { $clearCategoryQueryParams['sort_by'] = request('sort_by'); }
                        if (request('product_search')) { $clearCategoryQueryParams['product_search'] = request('product_search'); }
                        // Não adiciona 'category' para limpá-lo
                    @endphp
                    <a href="{{ route('products.index', $clearCategoryQueryParams) }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-times"></i> Limpar Categoria: {{ $categoryName }}
                    </a>
                @endif

                @if(request('product_search'))
                    @php
                        $hasActiveFilters = true;
                        $clearSearchQueryParams = [];
                        if (request('category')) { $clearSearchQueryParams['category'] = request('category'); }
                        if (request('sort_by')) { $clearSearchQueryParams['sort_by'] = request('sort_by'); }
                        // Não adiciona 'product_search' para limpá-lo
                    @endphp
                    <a href="{{ route('products.index', $clearSearchQueryParams) }}" class="btn btn-sm btn-outline-info me-2">
                        <i class="fas fa-search-minus"></i> Limpar Busca: "{{ request('product_search') }}"
                    </a>
                @endif
                
                {{-- Opcional: Botão para limpar TODOS os filtros se houver mais de um tipo de filtro ativo ou um filtro de ordenação não padrão --}}
                @php
                    $nonDefaultSort = request('sort_by') && request('sort_by') !== 'latest';
                @endphp
                @if($hasActiveFilters || $nonDefaultSort)
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-undo"></i> Limpar Todos os Filtros
                    </a>
                @endif
            </div>

            <p class="hero-subtitle mt-2" style="font-size: 1.2rem; color: var(--text-secondary);">
                @if($categoryName)
                    Confira os produtos disponíveis em {{ $categoryName }}.
                @else
                    Encontre os melhores gift cards e jogos digitais aqui!
                @endif
            </p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="d-flex flex-wrap gap-2 p-3 rounded" style="background-color: var(--glass-bg); border: 1px solid var(--glass-border);">
                    <div class="flex-grow-1">
                        <input type="text" name="product_search" class="form-control search-box" placeholder="{{ request()->get('search_box_placeholder', 'Procure por jogos, gift cards...') }}" value="{{ $searchTermToDisplay ?? request('product_search') }}" style="background-color: var(--dark-secondary); color: var(--text-primary); border-color: var(--glass-border); height: 50px;">
                    </div>
                    <div class="flex-shrink-0">
                        <select name="category" class="form-select" style="background-color: var(--dark-secondary); color: var(--text-primary); border-color: var(--glass-border); height: 50px;">
                            <option value="">Todas as Categorias</option>
                            @foreach($categories as $category_option)
                                <option value="{{ $category_option->slug }}" {{ request('category') == $category_option->slug ? 'selected' : '' }}>
                                    {{ $category_option->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-shrink-0">
                        <select name="sort_by" class="form-select" style="background-color: var(--dark-secondary); color: var(--text-primary); border-color: var(--glass-border); height: 50px;">
                            <option value="latest" {{ request('sort_by', 'latest') == 'latest' ? 'selected' : '' }}>Mais Recentes</option>
                            <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Preço: Menor para Maior</option>
                            <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Preço: Maior para Menor</option>
                            <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Nome: A-Z</option>
                            <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Nome: Z-A</option>
                        </select>
                    </div>
                    <div class="flex-shrink-0">
                        <button type="submit" class="btn hero-cta" style="height: 50px; padding: 0 2rem; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-filter me-2"></i>Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($products && $products->count() > 0)
        <div class="row games-grid g-4">
            @foreach($products as $product_item)
                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-flex align-items-stretch">
                    @include('partials.product_card', ['product' => $product_item])
                </div>
            @endforeach
        </div>

        @if ($products->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $products->appends(request()->except('page'))->links() }}       
        </div>
        @endif
    @else
        <div class="col-12 text-center p-5 rounded" style="background-color: var(--glass-bg); border: 1px solid var(--glass-border);">
            <i class="fas fa-ghost fa-3x mb-3" style="color: var(--primary-cyan);"></i>
            <h4 style="color: var(--text-secondary);">Nenhum produto encontrado.</h4>
            <p style="color: var(--text-muted);">Tente ajustar sua busca ou filtros.
                {{-- O link para limpar todos os filtros já está acima e é mais proeminente --}}
            </p>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Seus estilos existentes */
    .games-grid .game-card { background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 0.5rem; overflow: hidden; display: flex; flex-direction: column; height: 100%; transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
    .games-grid .game-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(var(--primary-purple-rgb, 138, 43, 226), 0.25), 0 0 0 2px var(--primary-cyan); }
    .game-card .game-image-link { display: block; }
    .game-card .game-image { width: 100%; aspect-ratio: 4 / 3; height: auto !important; overflow: hidden; background: linear-gradient(135deg, rgba(var(--primary-purple-rgb, 138, 43, 226), 0.1) 0%, rgba(var(--primary-cyan-rgb, 0, 255, 255), 0.1) 100%); position: relative; display: block; }
    .game-card .game-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .game-card .badge { font-size: 0.75rem; padding: 0.3em 0.6em; }
    .game-card .badge-featured { background-color: var(--primary-magenta); color: white; }
    .game-card .badge-unavailable { background-color: #6c757d; color: white; }
    .game-card .badge-low-stock { background-color: #ffc107; color: #212529; }
    .game-card .card-body { display: flex; flex-direction: column; flex-grow: 1; padding: 0.8rem 1rem; }
    .game-card .game-title a { font-size: 0.95rem; font-weight: 600; color: var(--primary-magenta); text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: calc(0.95rem * 1.4 * 2); line-height: 1.4; }
    .game-card .game-title a:hover { color: var(--primary-cyan); }
    .game-card .game-category a { font-size: 0.75rem; color: var(--text-secondary); text-decoration: none; }
    .game-card .game-category a:hover { color: var(--primary-magenta); }
    .game-card .game-price { color: var(--primary-cyan); font-size: 1.1rem; font-weight: bold; margin-top: 0.5rem; margin-bottom: 0.75rem; }
    .game-card .btn-add-to-cart,
    .game-card .btn-secondary[disabled] { background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-cyan) 100%); color: white; border:0; font-weight: 500; padding: 0.5rem 0.75rem; font-size: 0.85rem; width: 100%; }
    .game-card .btn-add-to-cart:hover { opacity: 0.9; }
    .game-card .btn-secondary[disabled] { background: #6c757d; opacity: 0.65; cursor: not-allowed; }
    .pagination .page-item .page-link { background-color: var(--dark-secondary); border-color: var(--glass-border); color: var(--text-secondary); margin: 0 2px; border-radius: 0.375rem; }
    .pagination .page-item.active .page-link { background-color: var(--primary-purple); border-color: var(--primary-purple); color: white; z-index: 3; }
    .pagination .page-item.disabled .page-link { background-color: var(--glass-bg); border-color: var(--glass-border); color: var(--text-muted); }
    .pagination .page-item .page-link:hover { background-color: var(--primary-purple); color: white; opacity: 0.8; }
    .pagination .page-item.active .page-link:hover { opacity: 1; }

    /* Novo estilo para o container dos botões de limpar filtros */
    .active-filters-cointainer a.btn {
        margin-bottom: 0.5rem; /* Espaçamento para telas menores quando os botões quebram linha */
    }
</style>
@endpush