@extends('layouts.app')

@section('title', 'Adicionar Novo Usuário - TokenStore')

@section('content')
<div class="container mt-5">
    {{-- BLOCO DE TÍTULO E BOTÕES DE NAVEGAÇÃO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="section-title" style="margin-bottom: 0;">Adicionar Novo Usuário</h1>
        <div>
            {{-- BOTÃO DE VOLTAR PARA A LISTA DE USUÁRIOS --}}
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-3" style="background-color: var(--dark-secondary); border-color: var(--glass-border); color: var(--text-secondary);">
                <i class="fas fa-list me-1"></i> Ver Lista de Usuários
            </a>
            {{-- BOTÃO DE VOLTAR PARA O PAINEL DO ADMIN --}}
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="background-color: var(--dark-secondary); border-color: var(--glass-border); color: var(--text-secondary);">
                <i class="fas fa-arrow-left me-1"></i> Voltar ao Painel
            </a>
        </div>
    </div>

    <div class="card" style="background: var(--glass-bg-darker, #2c2c2c); border-color: var(--glass-border, #444); color: var(--text-color, #fff);">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                {{-- Campos do formulário de usuário --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin">É Administrador?</label>
                </div>
                {{-- Fim dos campos --}}
                <button type="submit" class="btn hero-cta">Salvar Usuário</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2" style="background-color: var(--dark-secondary); border-color: var(--glass-border); color: var(--text-secondary);">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-label { color: var(--text-color, #fff) !important; }
    .form-control { background-color: var(--input-bg, #333) !important; color: var(--input-text-color, #fff) !important; border-color: var(--input-border-color, #555) !important; }
    .form-control:focus { border-color: var(--primary-cyan, #00bcd4) !important; box-shadow: 0 0 0 0.25rem rgba(0, 188, 212, 0.25) !important; }
    .form-check-input { background-color: var(--input-bg, #333) !important; border-color: var(--input-border-color, #555) !important; }
    .form-check-input:checked { background-color: var(--primary-cyan, #00bcd4) !important; border-color: var(--primary-cyan, #00bcd4) !important; }
    .invalid-feedback { color: var(--danger-text-strong, #f8d7da) !important; }
    .section-title { font-size: 2.25rem; font-weight: 800; color: var(--text-primary); text-shadow: 0 0 8px rgba(var(--primary-purple-rgb, 138, 43, 226), 0.5); }
     /* Defina suas variáveis --dark-secondary, etc. aqui ou globalmente */
    :root {
        --dark-secondary: #222; /* Exemplo */
        --glass-border: #444; /* Exemplo */
        --text-secondary: #aaa; /* Exemplo */
    }
</style>
@endpush