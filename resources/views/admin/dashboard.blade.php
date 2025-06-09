@extends('layouts.app')

@section('title', 'Admin Dashboard - TokenStore')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 section-title">Painel Administrativo</h1>
    <p class="hero-subtitle">Bem-vindo à área de administração, {{ Auth::user()->name }}.</p>

    <div class="row mt-4">
        <div class="col-md-6 mb-3">
            <div class="card admin-card" style="background: var(--glass-bg); border-color: var(--glass-border);">
                <div class="card-body text-center">
                    <i class="fas fa-box-open fa-3x mb-3" style="color: var(--primary-cyan);"></i>
                    <h5 class="card-title">Gerenciar Produtos</h5>
                    <p class="card-text">Adicionar, editar ou remover produtos da loja.</p>
                    <a href="{{ route('admin.products.index') }}" class="btn hero-cta">Ver Produtos</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card admin-card" style="background: var(--glass-bg); border-color: var(--glass-border);">
                <div class="card-body text-center">
                    <i class="fas fa-users-cog fa-3x mb-3" style="color: var(--primary-purple);"></i>
                    <h5 class="card-title">Gerenciar Usuários</h5>
                    <p class="card-text">Visualizar e editar informações de usuários.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn hero-cta">Ver Usuários</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- ADICIONANDO DE VOLTA O @push('styles') --}}
@push('styles')
<style>
    .admin-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .admin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }

    /* --- INÍCIO DAS CORREÇÕES DE COR PARA OS CARDS --- */
    .card .card-title { /* Mais específico para os títulos dentro dos cards */
        color: #ffffff !important; /* Cor branca para o título do card */
    }

    .card .card-text { /* Mais específico para os textos dentro dos cards */
        color: #e0e0e0 !important; /* Cor cinza claro para o texto do card */
    }
    /* --- FIM DAS CORREÇÕES DE COR PARA OS CARDS --- */
</style>
@endpush