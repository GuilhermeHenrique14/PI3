{{-- resources/views/orders/confirmation.blade.php --}}
@extends('layouts.app')

@section('title', 'Pedido Confirmado - TokenStore')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card text-center" 
                 style="background: var(--glass-bg, #2a2a3a);
                        border-radius: 15px;
                        padding: 35px 30px; 
                        border: 1px solid var(--glass-border, #444);
                        color: var(--text-primary, #e0e0e0);
                        box-shadow: var(--card-shadow, 0 4px 15px rgba(0,0,0,0.2));">

                <div class="confirmation-icon mb-4">
                    <i class="fas fa-check-circle" style="font-size: 5.5rem; color: var(--bs-success, #198754);"></i>
                </div>

                <h1 class="mb-3" style="font-weight: 700; font-size: 2.2rem; color: var(--text-primary);">
                    Obrigado pelo seu Pedido!
                </h1>

                <p class="mb-4" style="font-size: 1.1rem; color: var(--text-secondary);">
                    Seu pedido <strong style="color: var(--primary-cyan);">#{{ $order->id }}</strong> foi realizado com sucesso.
                </p>

                <div class="alert-custom alert-cyan-transparent my-4 p-3" style="text-align: left;">
                    <i class="fas fa-envelope me-2" style="color: var(--primary-cyan);"></i>
                    Enviamos um e-mail de confirmação para <strong style="color: var(--primary-magenta);">{{ $order->user->email }}</strong> com os detalhes da sua compra.
                </div>

                <div class="alert-custom alert-blue-transparent mb-5 p-3" style="text-align: left;">
                    <h5 class="mb-2" style="color: var(--primary-blue); font-weight: 600;">
                        <i class="fas fa-info-circle me-2"></i>Importante!
                    </h5>
                    <p class="mb-0" style="font-size: 0.95rem; color: var(--text-secondary);">
                        Seus gift cards serão entregues no seu e-mail em breve. Por favor, verifique sua caixa de entrada (e a pasta de spam) nos próximos minutos.
                    </p>
                </div>

                <div class="confirmation-actions">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <a href="{{ route('orders.show', $order->id) }}" 
                               class="btn btn-lg w-100 hero-cta"
                               style="padding: 0.75rem 1rem;"> 
                                <i class="fas fa-receipt me-2"></i>Ver Detalhes do Pedido
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" 
                               class="btn btn-lg w-100 btn-outline-light"
                               style="border-color: var(--primary-purple); color: var(--primary-purple); padding: 0.75rem 1rem;"
                               onmouseover="this.style.backgroundColor='rgba(var(--primary-purple-rgb), 0.2)';"
                               onmouseout="this.style.backgroundColor='transparent';">
                                <i class="fas fa-shopping-bag me-2"></i>Continuar Comprando
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .alert-custom {
        border-radius: 8px;
        border-width: 1px;
        border-style: solid;
    }

    .alert-cyan-transparent {
        background-color: rgba(var(--primary-cyan-rgb, 0, 255, 255), 0.08);
        border-color: rgba(var(--primary-cyan-rgb, 0, 255, 255), 0.3);
        color: var(--text-primary);
    }
    .alert-cyan-transparent strong {
        color: var(--primary-magenta);
    }

    .alert-blue-transparent {
        background-color: rgba(var(--primary-blue-rgb, 0, 123, 255), 0.08);
        border-color: rgba(var(--primary-blue-rgb, 0, 123, 255), 0.3);
        color: var(--text-secondary);
    }
    .alert-blue-transparent h5 {
        color: var(--primary-blue);
    }
    .alert-blue-transparent p {
        color: var(--text-secondary);
    }
</style>
@endpush