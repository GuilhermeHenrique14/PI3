@extends('layouts.app')

@section('title', 'Categoria: ' . $category->name)

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 section-title">Categoria: {{ $category->name }}</h1>
    @if($category->description)
        <p class="lead mb-4">{{ $category->description }}</p>
    @endif

    @if($products->isNotEmpty())
        <div class="row">
            @foreach($products as $product)
            {{-- Card do produto aqui, usando $product->name, $product->image, $product->price, etc. --}}
            {{-- Exemplo de card do produto: --}}
            <div class="col-md-3 col-6 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <img src="{{ asset($product->image ?? 'images/products/default_product.png') }}" class="card-img-top product-card-image" alt="{{ $product->name }}">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title product-name mb-1">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none">{{ Str::limit($product->name, 50) }}</a>
                        </h5>
                        <p class="card-text font-weight-bold product-price text-primary mb-3">
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        </p>
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary mt-auto align-self-start">Ver Detalhes</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $products->links() }} {{-- Links de Paginação --}}
        </div>
    @else
        <div class="alert alert-info text-center" role="alert">
            Nenhum produto encontrado nesta categoria no momento.
        </div>
    @endif
</div>
@endsection

@push('styles')
{{-- Estilos específicos se necessário --}}
<style>
    .section-title { font-weight: 300; text-transform: uppercase; letter-spacing: 1px; }
    .product-card { transition: box-shadow 0.2s ease-in-out; }
    .product-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.15); }
    .product-card-image { height: 200px; object-fit: contain; padding: 10px; }
    .product-name { font-size: 1rem; font-weight: 500; min-height: 40px; }
    .product-price { font-size: 1.2rem; }
</style>
@endpush