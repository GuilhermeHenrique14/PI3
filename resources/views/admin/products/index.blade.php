@extends('layouts.app') {{-- Se o seu layout admin for diferente, ajuste aqui. Ex: layouts.admin --}}

@section('title', 'Admin: Produtos - TokenStore')

@section('content')
<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="section-title" style="font-size: 2.5rem;">Gerenciar Produtos</h1>
        <div> {{-- Este div já existe para agrupar os botões à direita --}}
            {{-- BOTÃO DE VOLTAR PARA O PAINEL DO ADMIN --}}
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Voltar ao Painel do Admin
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn hero-cta">
                <i class="fas fa-plus me-1"></i> Novo Produto
            </a>
        </div>
    </div>

    @include('partials.alerts')

    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-4">
        <div class="input-group" style="background-color: var(--glass-bg); border-radius: 0.375rem; padding: 0.5rem;">
            <input type="text" name="search" class="form-control search-box" placeholder="Buscar produtos..." value="{{ request('search') }}" style="background-color: var(--dark-secondary); color: var(--text-primary); border-color: var(--glass-border); height: 50px;">
            <button class="btn hero-cta" type="submit" style="height: 50px;"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <div class="table-responsive rounded" style="background-color: var(--glass-bg); border: 1px solid var(--glass-border); padding: 1rem;">
        <table class="table table-dark table-hover align-middle" style="--bs-table-bg: transparent; --bs-table-hover-color: var(--primary-cyan);">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="60" class="rounded img-thumbnail" style="background-color: var(--dark-secondary); border-color: var(--glass-border);">
                    </td>
                    <td>{{ Str::limit($product->name, 40) }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->is_active)
                            <span class="badge" style="background-color: var(--primary-cyan); color: var(--dark-bg);">Ativo</span>
                        @else
                            <span class="badge bg-secondary">Inativo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm me-1" style="background-color: var(--primary-purple); color: white; border:0;"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background-color: var(--primary-magenta); color: white; border:0;"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="color: var(--text-secondary);">Nenhum produto encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($products->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-5-dark') }}
    </div>
    @endif
</div>
@endsection