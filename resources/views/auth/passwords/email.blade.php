@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #000000 0%, #0a0a0a 20%, #1a1a2e 40%, #16213e 60%, #0f3460 80%, #1a73e8 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .main-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .auth-card {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(25px);
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.7),
                    0 0 0 1px rgba(26, 115, 232, 0.2);
        border: 1px solid rgba(26, 115, 232, 0.3);
        overflow: hidden;
        max-width: 430px;
        width: 100%;
    }

    .auth-header {
        background: linear-gradient(135deg, #000000 0%, #1a1a2e 30%, #1a73e8 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .auth-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.05"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    }

    .auth-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        position: relative;
        z-index: 1;
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 1);
    }

    .auth-body {
        padding: 2.5rem;
        background: rgba(0, 0, 0, 0.3);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #f3f4f6;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(0, 0, 0, 0.4);
        color: #FFFFFF !important;
        backdrop-filter: blur(10px);
    }
    /* Adicionado padding para o ícone de visibilidade da senha */
    .password-input-wrapper .form-control {
        padding-right: 40px; /* Espaço para o ícone */
    }


    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .form-control:focus {
        outline: none;
        border-color: #1a73e8;
        background: rgba(0, 0, 0, 0.6);
        box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
    }

    .invalid-feedback {
        color: #fca5a5;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: block; /* Garantir que a mensagem seja visível */
    }

    .form-check {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .form-check-input {
        margin-right: 0.75rem;
        transform: scale(1.2);
        accent-color: #ec4899;
    }

    .form-check-label {
        color: #e5e7eb;
        font-size: 0.875rem;
    }

    .btn-primary {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        line-height: 1.5; /* Para melhor acomodar texto que pode quebrar linha */
        min-height: calc(1.5em + 1.75rem + 2px); /* Para garantir altura mínima similar ao input */
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(236, 72, 153, 0.4);
    }

    .auth-footer {
        background: rgba(255, 255, 255, 0.05);
        padding: 1.5rem 2.5rem;
        text-align: center;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .auth-footer p {
        margin: 0;
        color: #e5e7eb;
        font-size: 0.875rem;
    }

    .auth-footer a {
        color: #ec4899;
        text-decoration: none;
        font-weight: 600;
    }

    .auth-footer a:hover {
        color: #f472b6;
    }

    .forgot-password {
        text-align: center;
        margin-top: 1.5rem;
    }

    .forgot-password a {
        color: #e5e7eb;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .forgot-password a:hover {
        color: #ec4899;
    }

    /* Estilos para o wrapper do input de senha e ícone */
    .password-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-toggle-icon {
        position: absolute;
        right: 10px; /* Ajuste conforme necessário */
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #e0e0e0; /* Cor do ícone */
        user-select: none; /* Evita seleção do ícone */
        font-size: 1.2rem; /* Tamanho do ícone */
    }
    .alert-success { /* Estilo para a mensagem de status */
        background-color: rgba(76, 175, 80, 0.2);
        border: 1px solid rgba(76, 175, 80, 0.5);
        color: #a5d6a7;
        border-radius: 8px;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1.5rem;
    }


    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }

        .auth-body {
            padding: 2rem;
        }

        .auth-header {
            padding: 1.5rem;
        }

        .auth-title {
            font-size: 1.75rem; /* Título um pouco menor no header */
        }
    }
</style>

<div class="main-container">
    <div class="auth-card">
        <div class="auth-header">
            {{-- Título alterado para a página de redefinir senha --}}
            <h1 class="auth-title" style="font-size: 2rem;">Redefinir Senha</h1>
        </div>

        <div class="auth-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }} {{-- Esta mensagem geralmente já vem traduzida pelo Laravel se configurado para PT --}}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Endereço de Email</label>
                    <input id="email"
                           type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           autofocus
                           placeholder="Digite seu email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }} {{-- Mensagens de erro vêm do Laravel --}}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-primary mt-3"> {{-- Adicionei um mt-3 para leve espaçamento --}}
                    Enviar Link de Redefinição
                </button>
            </form>
        </div>

        <div class="auth-footer">
            <p><a href="{{ route('login') }}">Voltar para o Login</a></p>
        </div>
    </div>
</div>

{{-- O script de visibilidade da senha não é necessário aqui, pois não há campo de senha --}}
@endsection