@extends('layouts.app')

@section('title', 'Editar Usuário - TokenStore')

@section('content')
<div class="container mt-5">
    {{-- BLOCO DE TÍTULO E BOTÕES DE NAVEGAÇÃO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="section-title" style="margin-bottom: 0;">Editar Usuário: {{ Str::limit($user->name, 30) }}</h1>
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
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nova Senha (deixe em branco para não alterar)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->is_admin ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin">É Administrador?</label>
                </div>

                <button type="submit" class="btn hero-cta">Atualizar Usuário</button>
                {{-- O botão cancelar já usa btn-secondary e o estilo que queremos, mas o style inline dele pode ser redundante se as vars CSS estiverem globais --}}
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2" style="background-color: var(--dark-secondary); border-color: var(--glass-border); color: var(--text-secondary);">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Estilos do formulário (já estavam aqui) */
    .form-label {
        color: var(--text-color, #fff) !important;
    }
    .form-control {
        background-color: var(--input-bg, #333) !important;
        color: var(--input-text-color, #fff) !important;
        border-color: var(--input-border-color, #555) !important;
    }
    .form-control:focus {
        border-color: var(--primary-cyan, #00bcd4) !important;
        box-shadow: 0 0 0 0.25rem rgba(0, 188, 212, 0.25) !important;
    }
    .form-check-input {
        background-color: var(--input-bg, #333) !important;
        border-color: var(--input-border-color, #555) !important;
    }
    .form-check-input:checked {
        background-color: var(--primary-cyan, #00bcd4) !important;
        border-color: var(--primary-cyan, #00bcd4) !important;
    }
    .invalid-feedback {
        color: var(--danger-text-strong, #f8d7da) !important;
    }
    .section-title {
        font-size: 2.25rem; 
        font-weight: 800; 
        color: var(--text-primary); 
        text-shadow: 0 0 8px rgba(var(--primary-purple-rgb, 138, 43, 226), 0.5);
    }

    /* Defina suas variáveis CSS aqui se não estiverem globais, 
       ou garanta que estão no seu CSS principal (ex: app.css) */
    :root {
        /* Estas são as variáveis usadas nos botões de navegação e no botão Cancelar */
        --dark-secondary: #2c3e50; /* Exemplo: um cinza escuro azulado, ajuste para o seu tema */
        --glass-border: #4a69bd;   /* Exemplo: um azul mais claro para borda, ajuste */
        --text-secondary: #bdc3c7; /* Exemplo: um cinza claro para texto, ajuste */
        
        /* Variáveis já usadas no seu código */
        --text-color: #fff; /* Exemplo, ajuste */
        --input-bg: #333; /* Exemplo, ajuste */
        --input-text-color: #fff; /* Exemplo, ajuste */
        --input-border-color: #555; /* Exemplo, ajuste */
        --primary-cyan: #00bcd4; /* Exemplo, ajuste */
        --danger-text-strong: #f8d7da; /* Exemplo, ajuste */
        --text-primary: #fff; /* Exemplo, ajuste */
        --primary-purple-rgb: 138, 43, 226; /* Exemplo, ajuste */

        /* Variáveis usadas no card e form, caso não sejam globais */
        --glass-bg-darker: #2c2c2c; /* Exemplo, ajuste */
        /* --glass-border já está acima */
    }
</style>
@endpush