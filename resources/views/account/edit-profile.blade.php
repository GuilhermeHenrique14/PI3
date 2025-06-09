@extends('layouts.app')

@section('title', 'Editar Perfil - TokenStore')

@push('styles')
<style>
    :root {
        --ts-purple: #7c3aed; --ts-purple-dark: #5b21b6; --ts-purple-light: #a78bfa;
        --ts-cyan: #22d3ee; --ts-cyan-dark: #0e7490; --ts-magenta: #d946ef; --ts-blue: #3b82f6;
        --ts-text-light: #f9fafb; --ts-text-medium: #d1d5db; --ts-text-darker: #4b5563;
        --ts-bg-main: #111827; --ts-card-bg: #1f2937; --ts-card-header-bg: #374151;
        --ts-card-border: var(--ts-purple-light);
        --ts-input-bg: #374151;
        --ts-input-border: #4b5563;
        --ts-input-focus-border: var(--ts-cyan);
        --ts-input-text: var(--ts-text-light);
        --ts-success-bg: rgba(34, 197, 94, 0.1); /* Verde mais sutil */
        --ts-success-text: #22c55e;
        --ts-success-border: #16a34a;
        --ts-error-bg: rgba(239, 68, 68, 0.1); /* Vermelho mais sutil */
        --ts-error-text: #ef4444;
        --ts-error-border: #dc2626;
        --ts-info-bg: rgba(59, 130, 246, 0.1); /* Azul mais sutil */
        --ts-info-text: #3b82f6;
        --ts-info-border: #2563eb;
        --ts-purple-rgb: 124, 58, 237; --ts-cyan-rgb: 34, 211, 238;
    }
    body { background-color: var(--ts-bg-main) !important; font-family: 'Inter', sans-serif; }
    .readable-container { color: var(--ts-text-light); }

    .page-title-tokenstore {
        font-size: 2rem; /* Reduzido um pouco */
        font-weight: 700; /* Um pouco menos bold */
        margin-bottom: 1.5rem; /* Menor margem */
        color: var(--ts-text-light); text-shadow: 0 0 7px rgba(var(--ts-purple-rgb), 0.4);
    }
    .page-title-tokenstore span { color: var(--ts-cyan); }
    
    .form-card-tokenstore {
        background-color: var(--ts-card-bg); border: 1px solid var(--ts-card-border);
        border-radius: 10px; /* Um pouco menos arredondado */
        margin-bottom: 1.5rem;
        box-shadow: 0 3px 5px -1px rgba(0,0,0,0.08), 0 2px 3px -1px rgba(0,0,0,0.05);
    }
    .form-card-header-tokenstore {
        background-color: var(--ts-card-header-bg); color: var(--ts-text-light);
        padding: 0.875rem 1.25rem; /* Ajustado padding */
        border-bottom: 1px solid rgba(var(--ts-purple-rgb), 0.15); /* Borda mais sutil */
    }
    .form-card-header-tokenstore h5 { font-size: 1.05rem; font-weight: 600; margin-bottom: 0; } /* Ajustado tamanho e peso */
    .form-card-header-tokenstore p { font-size: 0.8rem; color: var(--ts-text-medium); margin-top: 0.15rem; } /* Ajustado */
    .form-card-body-tokenstore { padding: 1.25rem; } /* Ajustado padding */

    .form-label-ts {
        display: block; margin-bottom: 0.375rem; font-size: 0.8rem; font-weight: 500; color: var(--ts-text-medium);
    }
    .form-input-ts {
        width: 100%;
        background-color: var(--ts-input-bg); border: 1px solid var(--ts-input-border);
        color: var(--ts-input-text); font-size: 0.875rem; border-radius: 6px; /* Menos arredondado */
        padding: 0.625rem 0.875rem; /* Padding ajustado */
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .form-input-ts:focus {
        outline: none; border-color: var(--ts-input-focus-border);
        box-shadow: 0 0 0 2px rgba(var(--ts-cyan-rgb), 0.25); /* Sombra de foco mais sutil */
    }
    .form-input-ts::placeholder { color: var(--ts-text-darker); opacity: 0.7; }
    .form-input-error-ts { border-color: var(--ts-error-border) !important; } /* Adicionado !important para garantir prioridade */
    .form-error-message-ts { color: var(--ts-error-text); font-size: 0.75rem; margin-top: 0.3rem; }

    .form-actions-ts { display: flex; align-items: center; justify-content: flex-start; gap: 0.75rem; margin-top:1.25rem;}
    .btn-ts {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0.5rem 1rem; /* Padding ajustado */
        border-radius: 6px; font-weight: 500; font-size: 0.875rem; /* Peso e tamanho ajustados */
        transition: all 0.2s ease; border: 1px solid transparent; cursor: pointer; text-decoration: none;
    }
    .btn-ts.primary {
        background: linear-gradient(to right, var(--ts-purple), var(--ts-magenta)); color: white;
        box-shadow: 0 1px 2px rgba(var(--ts-purple-rgb), 0.25);
    }
    .btn-ts.primary:hover { opacity: 0.9; box-shadow: 0 2px 4px rgba(var(--ts-magenta-rgb), 0.35); }
    .btn-ts.secondary {
        background-color: var(--ts-card-header-bg); color: var(--ts-text-light);
        border: 1px solid var(--ts-input-border);
    }
    .btn-ts.secondary:hover { background-color: var(--ts-input-border); color: var(--ts-text-light); }

    .status-message-ts {
        padding: 0.75rem 1rem; margin-bottom: 1rem; border-radius: 6px; font-size: 0.875rem;
        display: flex; align-items: center;
    }
    .status-message-ts i { margin-right: 0.5rem; font-size: 1.1em; }
    .status-message-ts.success {
        background-color: var(--ts-success-bg); color: var(--ts-success-text); border: 1px solid var(--ts-success-border);
    }
    .status-message-ts.error { /* Para erros gerais, se necessário */
        background-color: var(--ts-error-bg); color: var(--ts-error-text); border: 1px solid var(--ts-error-border);
    }
    .status-message-ts.info { /* Para mensagens de verificação de email */
        background-color: var(--ts-info-bg); color: var(--ts-info-text); border: 1px solid var(--ts-info-border);
    }
</style>
@endpush

@section('content')
<div class="container mx-auto p-4 md:px-6 lg:px-8 readable-container max-w-3xl"> {{-- Limitado a largura para melhor leitura --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5">
        <h1 class="page-title-tokenstore">Editar <span>Perfil</span></h1>
        <a href="{{ route('account.index') }}" class="btn-ts secondary mt-2 sm:mt-0">
            <i class="fas fa-arrow-left mr-2"></i> Voltar para Minha Conta
        </a>
    </div>

    {{-- Formulário de Informações do Perfil --}}
    <section class="form-card-tokenstore" id="update-profile-section">
        <header class="form-card-header-tokenstore">
            <h5>Informações do Perfil</h5>
            <p>Atualize as informações de nome e email da sua conta.</p>
        </header>
        <div class="form-card-body-tokenstore">
            @if (session('status') === 'profile-updated')
                <div class="status-message-ts success" role="alert">
                    <i class="fas fa-check-circle"></i>
                    Perfil atualizado com sucesso!
                </div>
            @endif

            <form method="POST" action="{{ route('account.update-profile') }}" id="form-update-profile">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="form-label-ts">Nome</label>
                    <input type="text" name="name" id="name" class="form-input-ts @error('name') form-input-error-ts @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    @error('name') {{-- Removido 'updateProfile' do error bag, pois é o padrão para o form --}}
                        <p class="form-error-message-ts">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label-ts">Email</label>
                    <input type="email" name="email" id="email" class="form-input-ts @error('email') form-input-error-ts @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')
                        <p class="form-error-message-ts">{{ $message }}</p>
                    @enderror
                </div>
                
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mb-4 status-message-ts info">
                        <i class="fas fa-info-circle"></i>
                        <span>
                            Seu endereço de e-mail não foi verificado.
                            @if(Route::has('verification.send'))
                                <button form="send-verification" class="underline text-sm hover:text-[var(--ts-cyan)] focus:outline-none ml-1">
                                    Clique aqui para reenviar o e-mail de verificação.
                                </button>
                            @endif
                        </span>
                    </div>
                    @if (session('status') === 'verification-link-sent')
                        <div class="status-message-ts success mb-4">
                            <i class="fas fa-check-circle"></i>
                            Um novo link de verificação foi enviado para o seu endereço de e-mail.
                        </div>
                    @endif
                @endif

                <div class="form-actions-ts">
                    <button type="submit" class="btn-ts primary">
                        <i class="fas fa-save mr-2"></i>Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- Formulário de Atualização de Senha --}}
    <section class="form-card-tokenstore" id="update-password-section">
        <header class="form-card-header-tokenstore">
            <h5>Atualizar Senha</h5>
            <p>Garanta que sua conta esteja usando uma senha longa e aleatória para se manter segura.</p>
        </header>
        <div class="form-card-body-tokenstore">
            @if (session('status') === 'password-updated')
                <div class="status-message-ts success" role="alert">
                    <i class="fas fa-check-circle"></i>
                    Senha atualizada com sucesso!
                </div>
            @endif
            @if ($errors->updatePassword->any()) {{-- Exibe erros gerais do form de senha se houver --}}
                 <div class="status-message-ts error mb-4" role="alert">
                    <i class="fas fa-times-circle"></i>
                    <span>Por favor, corrija os erros abaixo no formulário de senha.</span>
                </div>
            @endif


            <form method="POST" action="{{ route('account.update-password') }}" id="form-update-password">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="current_password" class="form-label-ts">Senha Atual</label>
                    <input type="password" name="current_password" id="current_password" class="form-input-ts @error('current_password', 'updatePassword') form-input-error-ts @enderror" required autocomplete="current-password">
                    @error('current_password', 'updatePassword')
                        <p class="form-error-message-ts">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label-ts">Nova Senha</label>
                    <input type="password" name="password" id="password" class="form-input-ts @error('password', 'updatePassword') form-input-error-ts @enderror" required autocomplete="new-password">
                    @error('password', 'updatePassword')
                        <p class="form-error-message-ts">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label-ts">Confirmar Nova Senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input-ts" required autocomplete="new-password">
                    {{-- Não precisa de erro específico para password_confirmation, pois a regra 'confirmed' no campo 'password' já cuida disso --}}
                </div>

                <div class="form-actions-ts">
                    <button type="submit" class="btn-ts primary">
                        <i class="fas fa-key mr-2"></i>Atualizar Senha
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

@if(Route::has('verification.send'))
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>
@endif
@endsection

@push('scripts')
<script>
    // Pequeno script para rolar para a seção com erro ou mensagem de status
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status'); // Se você passar o status via URL

        // Se houver uma mensagem de status vinda da sessão (após redirecionamento)
        @if (session('status') === 'profile-updated')
            document.getElementById('update-profile-section')?.scrollIntoView({ behavior: 'smooth' });
        @elseif (session('status') === 'password-updated')
            document.getElementById('update-password-section')?.scrollIntoView({ behavior: 'smooth' });
        @elseif (session('status') === 'verification-link-sent')
            document.getElementById('update-profile-section')?.scrollIntoView({ behavior: 'smooth' });
        @endif

        // Rolar para a seção com erro, se houver erros de validação
        @if ($errors->any())
            @if ($errors->hasBag('default') && ($errors->getBag('default')->has('name') || $errors->getBag('default')->has('email')))
                document.getElementById('update-profile-section')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            @elseif ($errors->hasBag('updatePassword') && ($errors->getBag('updatePassword')->has('current_password') || $errors->getBag('updatePassword')->has('password')))
                document.getElementById('update-password-section')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            @endif
        @endif
    });
</script>
@endpush