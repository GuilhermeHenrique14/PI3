@extends('layouts.app')

@section('title', 'Minha Conta - TokenStore')

@push('styles')
<style>
    :root {
        --ts-purple: #7c3aed; --ts-purple-dark: #5b21b6; --ts-purple-light: #a78bfa;
        --ts-cyan: #22d3ee; --ts-cyan-dark: #0e7490; --ts-magenta: #d946ef; --ts-blue: #3b82f6;
        --ts-text-light: #f9fafb; --ts-text-medium: #d1d5db; --ts-text-darker: #4b5563;
        --ts-bg-main: #111827; --ts-card-bg: #1f2937; --ts-card-header-bg: #374151;
        --ts-card-border: var(--ts-purple-light);
        --ts-purple-rgb: 124, 58, 237; --ts-cyan-rgb: 34, 211, 238;
    }
    body { background-color: var(--ts-bg-main) !important; font-family: 'Inter', sans-serif; }
    .readable-container { color: var(--ts-text-light); }
    
    .page-title-tokenstore {
        font-size: 2.25rem; font-weight: 800; margin-bottom: 0.5rem;
        color: var(--ts-text-light); text-shadow: 0 0 8px rgba(var(--ts-purple-rgb), 0.5);
    }
    .page-title-tokenstore span { color: var(--ts-cyan); }

    .account-welcome-text {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        text-align: left;
        color: var(--ts-text-medium);
    }
    .account-welcome-text strong {
        color: var(--ts-cyan);
        font-weight: 600;
    }

    .main-card-tokenstore {
        background-color: var(--ts-card-bg); border: 1px solid var(--ts-card-border);
        border-radius: 12px; margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1); overflow: hidden;
    }
    .main-card-header-tokenstore {
        background-color: var(--ts-card-header-bg); color: var(--ts-text-light);
        padding: 1rem 1.5rem; border-bottom: 1px solid rgba(var(--ts-purple-rgb), 0.2);
        display: flex; align-items: center; justify-content: space-between;
    }
    .main-card-header-tokenstore .header-content {
        display: flex; align-items: center;
    }
    .main-card-header-tokenstore i { margin-right: 0.75rem; font-size: 1.25rem; color: var(--ts-purple-light); }
    .main-card-header-tokenstore h5 { font-size: 1.125rem; font-weight: 600; margin-bottom: 0; }
    .main-card-body-tokenstore { padding: 1.5rem; }

    .info-group { margin-bottom: 1rem; }
    .info-label {
        color: var(--ts-text-medium);
        font-size: 0.8rem; /* text-xs */
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem; /* mb-1 */
        display: block;
    }
    .info-value {
        color: var(--ts-text-light);
        font-size: 1rem; /* text-base */
        font-weight: 500; /* medium */
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .action-card-link {
        display: block;
        text-decoration: none;
    }
    .action-card {
        background-color: var(--ts-card-bg);
        border: 1px solid var(--ts-card-border);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 160px;
    }
    .action-card:hover {
        border-color: var(--ts-cyan);
        transform: translateY(-4px);
        box-shadow: 0 6px 12px rgba(var(--ts-cyan-rgb), 0.2);
    }
    .action-card i {
        font-size: 2.25rem; /* text-3xl ou text-4xl */
        color: var(--ts-cyan);
        margin-bottom: 0.75rem;
    }
    .action-card h6 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--ts-text-light);
        margin-bottom: 0.25rem;
    }
    .action-card p {
        font-size: 0.875rem;
        color: var(--ts-text-medium);
        line-height: 1.4;
    }

    .btn-ts {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; font-size: 0.875rem;
        transition: all 0.2s ease; border: 1px solid transparent; cursor: pointer;
        text-decoration: none;
    }
    .btn-ts.primary {
        background: linear-gradient(to right, var(--ts-purple), var(--ts-magenta)); color: white;
        box-shadow: 0 2px 4px rgba(var(--ts-purple-rgb), 0.3);
    }
    .btn-ts.primary:hover { opacity: 0.9; box-shadow: 0 4px 8px rgba(var(--ts-magenta-rgb), 0.4); }
    .btn-ts.outline {
        background-color: transparent; color: var(--ts-cyan); border-color: var(--ts-cyan);
    }
    .btn-ts.outline:hover { background-color: rgba(var(--ts-cyan-rgb), 0.1); }
    .btn-ts i { margin-right: 0.5rem; }
</style>
@endpush

@section('content')
<div class="container mx-auto p-4 md:p-6 readable-container">

    <h1 class="page-title-tokenstore">Minha <span>Conta</span></h1>
    <p class="account-welcome-text">Olá, <strong>{{ $user->name }}</strong>! Bem-vindo(a) ao seu painel.</p>

    <div class="main-card-tokenstore">
        <div class="main-card-header-tokenstore">
            <div class="header-content">
                <i class="fas fa-id-card"></i>
                <h5>Suas Informações</h5>
            </div>
            {{-- Link para editar perfil --}}
            <a href="{{ route('account.edit-profile') }}" class="btn-ts outline text-sm">
                <i class="fas fa-user-edit"></i> Editar Perfil
            </a>
        </div>
        <div class="main-card-body-tokenstore">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                <div class="info-group">
                    <span class="info-label">Nome Completo</span>
                    <p class="info-value">{{ $user->name }}</p>
                </div>
                <div class="info-group">
                    <span class="info-label">Endereço de Email</span>
                    <p class="info-value">{{ $user->email }}</p>
                </div>
                <div class="info-group">
                    <span class="info-label">Membro Desde</span>
                    <p class="info-value">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="info-group">
                    <span class="info-label">Total de Pedidos</span>
                    <p class="info-value">{{ $orderCount }}</p>
                </div>
                 @if ($user->email_verified_at)
                    <div class="info-group">
                        <span class="info-label">Email Verificado</span>
                        <p class="info-value text-green-400 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>Verificado em {{ $user->email_verified_at->format('d/m/Y') }}
                        </p>
                    </div>
                @else
                    <div class="info-group">
                        <span class="info-label">Email Verificado</span>
                        <p class="info-value text-yellow-400 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Não verificado
                            @if(Route::has('verification.send'))
                                <form class="inline" method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="ml-2 text-sm text-[var(--ts-cyan)] hover:underline focus:outline-none">
                                        (Reenviar email de verificação)
                                    </button>
                                </form>
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="action-grid">
        <a href="{{ route('orders.index') }}" class="action-card-link">
            <div class="action-card">
                <i class="fas fa-receipt"></i>
                <h6>Meus Pedidos</h6>
                <p>Acompanhe seu histórico de compras e o status dos seus pedidos.</p>
            </div>
        </a>
        
        <a href="#" class="action-card-link" onclick="event.preventDefault(); document.getElementById('logout-form-account').submit();">
            <div class="action-card">
                <i class="fas fa-sign-out-alt" style="color: #f87171;"></i>
                <h6 style="color: #f87171;">Sair da Conta</h6>
                <p>Desconecte-se da sua conta TokenStore.</p>
            </div>
        </a>
        <form id="logout-form-account" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>
@endsection