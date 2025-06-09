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
    transition: color 0.3s ease, transform 0.3s ease, text-shadow 0.3s ease;
    display: inline-block; /* Necessário para transform funcionar corretamente */
    padding: 2px 0; /* Adiciona um pouco de espaço vertical para o efeito de escala não cortar */
}

.forgot-password a:hover {
    color: #f472b6; /* Um tom um pouco mais claro do rosa para o brilho */
    transform: scale(1.05); /* Aumenta levemente o tamanho */
    text-shadow: 0 0 8px rgba(236, 72, 153, 0.7); /* Adiciona um brilho suave */
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
            font-size: 1.75rem;
        }
    }
</style>

<div class="main-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1 class="auth-title">TokenStore</h1>
        </div>
        
        <div class="auth-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" 
                           type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus
                           placeholder="Enter your email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Senha</label>
                    <div class="password-input-wrapper">
                        <input id="password" 
                               type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="Enter your password">
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('password', this)">👁️</span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback" style="display: block;"> {{-- Garantir que o feedback apareça abaixo do wrapper --}}
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="remember" 
                           id="remember" 
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember Me
                    </label>
                </div>

                <button type="submit" class="btn-primary">
                    Login
                </button>

                @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">
                            Esqueceu sua senha?
                        </a>
                    </div>
                @endif
            </form>
        </div>
        
        <div class="auth-footer">
            <p>Não possui uma conta? <a href="{{ route('register') }}">Cadastro</a></p>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(fieldId, eyeIcon) {
        const passwordField = document.getElementById(fieldId);
        if (passwordField) {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            eyeIcon.textContent = type === 'password' ? '👁️' : '🙈'; // Alterna o ícone
        }
    }
</script>
@endsection