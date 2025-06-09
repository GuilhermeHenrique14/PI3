@extends('layouts.app') {{-- Ou o seu layout admin --}}

@section('title', 'Admin: Editar Produto - TokenStore')

@section('content')
<div class="container mt-5 mb-5">
    {{-- BLOCO DE TÍTULO E BOTÕES DE NAVEGAÇÃO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="section-title" style="font-size: 2.5rem; margin-bottom: 0;">Editar Produto: {{ Str::limit($product->name, 30) }}</h1>
        <div>
            {{-- BOTÃO DE VOLTAR PARA A LISTA DE PRODUTOS --}}
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-3" style="background-color: var(--dark-secondary); border-color: var(--glass-border); color: var(--text-secondary);"> 
                <i class="fas fa-list me-1"></i> Ver Lista de Produtos
            </a>
            {{-- BOTÃO DE VOLTAR PARA O PAINEL DO ADMIN --}}
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="background-color: var(--dark-secondary); border-color: var(--glass-border); color: var(--text-secondary);">
                <i class="fas fa-arrow-left me-1"></i> Voltar ao Painel
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="background-color: rgba(var(--primary-magenta-rgb, 255, 0, 255), 0.2); border-color: var(--primary-magenta); color: var(--text-primary); border-radius: 0.5rem;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
          style="background-color: var(--glass-bg); border: 1px solid var(--glass-border); padding: 2rem; border-radius: 0.5rem;">
        @csrf
        @method('PUT')
        @include('admin.products._form', ['product' => $product, 'categories' => $categories ?? []])
    </form></div>
@endsection