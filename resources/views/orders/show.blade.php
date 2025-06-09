@extends('layouts.app')

@section('title', 'Detalhes do Pedido #' . $order->id . ' - TokenStore')

@push('styles')
<style>
    /* As variáveis CSS globais (--dark-secondary, --glass-border, --text-secondary, etc.) 
       são carregadas do seu app.blade.php. */

    :root {
        /* Variáveis específicas desta página ou que complementam o global */
        --ts-purple: #7c3aed;
        --ts-purple-dark: #5b21b6;
        --ts-purple-light: #a78bfa;
        --ts-cyan: #22d3ee;
        --ts-cyan-dark: #0e7490;
        --ts-magenta: #d946ef;
        --ts-blue: #3b82f6;
        
        --ts-text-light: #f9fafb;
        --ts-text-medium: #d1d5db;
        --ts-text-darker: #4b5563;

        --ts-bg-main: #111827;
        --ts-card-bg: #1f2937;
        --ts-card-header-bg: #374151;
        --ts-card-border: var(--ts-purple-light);

        --ts-purple-rgb: 124, 58, 237;
        --ts-cyan-rgb: 34, 211, 238;
        --ts-magenta-rgb: 217, 70, 239;
    }

    .readable-container {
        color: var(--ts-text-light);
        font-family: 'Inter', sans-serif;
    }

    .page-header-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 2.5rem;
    }

    .page-header-container .page-title-tokenstore {
        margin-bottom: 1rem;
    }

    @media (min-width: 640px) {
        .page-header-container {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .page-header-container .page-title-tokenstore {
            margin-bottom: 0;
        }
    }

    .page-title-tokenstore {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--ts-text-light);
        text-shadow: 0 0 8px rgba(var(--ts-purple-rgb), 0.5);
    }
    .page-title-tokenstore span {
        color: var(--ts-cyan);
    }

    .main-card-tokenstore {
        background-color: var(--ts-card-bg);
        border: 1px solid var(--ts-card-border);
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .main-card-header-tokenstore {
        background-color: var(--ts-card-header-bg);
        color: var(--ts-text-light);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--ts-card-border);
        display: flex;
        align-items: center;
    }
    .main-card-header-tokenstore i { margin-right: 0.75rem; font-size: 1.25rem; color: var(--ts-purple-light); }
    .main-card-header-tokenstore h5 { font-size: 1.125rem; font-weight: 600; margin-bottom: 0; }
    .main-card-body-tokenstore { padding: 1.5rem; }
    .item-entry { background-color: rgba(var(--ts-purple-rgb), 0.05); border: 1px solid rgba(var(--ts-purple-rgb), 0.2); border-radius: 8px; padding: 1rem; margin-bottom: 1rem; display: flex; align-items: center; transition: background-color 0.2s ease; }
    .item-entry:hover { background-color: rgba(var(--ts-purple-rgb), 0.1); }
    .item-entry-image { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; margin-right: 1rem; border: 1px solid rgba(var(--ts-cyan-rgb), 0.3); }
    .item-entry-placeholder { width: 60px; height: 60px; border-radius: 6px; margin-right: 1rem; display: flex; align-items: center; justify-content: center; background-color: rgba(var(--ts-cyan-rgb), 0.1); border: 1px solid rgba(var(--ts-cyan-rgb), 0.3); }
    .item-entry-placeholder i { font-size: 1.75rem; color: var(--ts-cyan); }
    .item-entry-details h6 { font-size: 1rem; font-weight: 600; color: var(--ts-text-light); margin-bottom: 0.25rem; }
    .item-entry-details p { font-size: 0.875rem; color: var(--ts-text-medium); margin-bottom: 0; }
    .item-entry-subtotal { font-size: 0.95rem; font-weight: 700; color: var(--ts-text-light); text-align: right; margin-left: auto; min-width: 90px; }
    .summary-line { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.625rem; font-size: 0.9375rem; }
    .summary-line span:first-child { color: var(--ts-text-medium); }
    .summary-line span:last-child { font-weight: 600; color: var(--ts-text-light); }
    .summary-line.total .value { font-size: 1.375rem; color: var(--ts-cyan) !important; }
    .summary-divider-line { height: 1px; background-color: rgba(var(--ts-purple-rgb), 0.2); margin: 1rem 0; }
    .status-pill { padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.75rem; font-weight: 600; text-transform: capitalize; }
    .status-pill.success { background-color: #16a34a; color: white; }
    .status-pill.warning { background-color: #d97706; color: white; }
    .status-pill.info    { background-color: var(--ts-blue) ; color: white; }
    .status-pill.danger  { background-color: #dc2626; color: white; }
    .gift-code-area { background-color: rgba(var(--ts-purple-rgb), 0.1); border: 1px solid rgba(var(--ts-purple-rgb), 0.25); border-radius: 8px; padding: 0.75rem 1rem; margin-top: 0.25rem; display: flex; justify-content: space-between; align-items: center; }
    .gift-code-text { font-family: 'Roboto Mono', monospace; font-size: 1rem; color: var(--ts-cyan); letter-spacing: 0.05em; }
    .gift-code-btn-copy { background-color: var(--ts-cyan); color: var(--ts-text-darker); padding: 0.375rem 0.75rem; font-size: 0.75rem; border-radius: 6px; font-weight: 600; }
    .alert-box { padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem; border-width: 1px; border-style: solid; display: flex; align-items: center; }
    .alert-box i { margin-right: 0.5rem; font-size: 1.125rem; }
    .alert-box.success { background-color: rgba(22, 163, 74, 0.1); border-color: rgba(22, 163, 74, 0.3); color: #4ade80; }
    .alert-box.info { background-color: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.3); color: #93c5fd; }

    /* Estilos .btn-ts para o botão "Contatar Suporte" */
    .btn-ts {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-ts.primary {
        background: linear-gradient(to right, var(--ts-purple), var(--ts-magenta));
        color: white;
        box-shadow: 0 2px 4px rgba(var(--ts-purple-rgb), 0.3);
    }
    .btn-ts.primary:hover {
        opacity: 0.9;
        box-shadow: 0 4px 8px rgba(var(--ts-magenta-rgb), 0.4);
    }
    .btn-ts i { margin-right: 0.5rem; }

</style>
@endpush

@section('content')
<div class="container mx-auto p-4 md:p-6 readable-container">
    <div class="page-header-container">
        <h1 class="page-title-tokenstore">Pedido <span>#{{ $order->id }}</span></h1>
        <a href="{{ route('orders.index') }}"
           class="btn"
           style="
               background-color: var(--dark-secondary);
               color: var(--text-secondary);
               border-width: 1px;
               border-style: solid;
               border-color: var(--glass-border);
               padding: 0.375rem 0.75rem;
               border-radius: 0.375rem;
               font-size: 1rem;
               font-weight: 400;
               line-height: 1.5;
               text-align: center;
               text-decoration: none;
               vertical-align: middle;
               cursor: pointer;
               user-select: none;
               white-space: nowrap;
           "
        >
            <i class="fas fa-arrow-left me-1"></i>
            Voltar para Pedidos
        </a>
    </div>

    {{-- RESTANTE DO CONTEÚDO DA PÁGINA... --}}
    <div class="flex flex-wrap -mx-3">
        <div class="w-full lg:w-7/12 px-3 mb-6 lg:mb-0">
            <div class="main-card-tokenstore">
                <div class="main-card-header-tokenstore">
                    <i class="fas fa-shopping-basket"></i>
                    <h5>Itens Comprados</h5>
                </div>
                <div class="main-card-body-tokenstore">
                    @forelse($order->items as $item)
                        <div class="item-entry">
                            @if($item->product && $item->product->image_path)
                                <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name ?? 'Produto' }}" class="item-entry-image">
                            @else
                                <div class="item-entry-placeholder"><i class="fas fa-gift"></i></div>
                            @endif
                            <div class="item-entry-details">
                                <h6>{{ $item->product->name ?? 'Produto Indisponível' }}</h6>
                                <p>Qtde: {{ $item->quantity }} | Preço Unit.: R$ {{ number_format($item->price, 2, ',', '.') }}</p>
                            </div>
                            <div class="item-entry-subtotal">
                                R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-3 text-[var(--ts-text-medium)]">Este pedido não possui itens.</p>
                    @endforelse
                </div>
            </div>

            @if($order->items->count() > 0)
            <div class="main-card-tokenstore">
                <div class="main-card-header-tokenstore">
                    <i class="fas fa-key"></i>
                    <h5>Seus Códigos</h5>
                </div>
                <div class="main-card-body-tokenstore">
                    @if($order->status === 'completed')
                        <div class="alert-box success" role="alert">
                            <i class="fas fa-shield-alt"></i>
                            <div>Seus códigos estão disponíveis abaixo.</div>
                        </div>
                        @foreach($order->items as $item)
                            @if($item->product)
                            <div class="mb-3">
                                <p class="font-semibold text-sm mb-0.5 text-[var(--ts-text-light)]">{{ $item->product->name }}:</p>
                                <div class="gift-code-area">
                                    <span class="gift-code-text" id="gift-code-{{ $item->id }}">{{ $item->gift_card_code ?? 'PENDENTE' }}</span>
                                    @if($item->gift_card_code && $item->gift_card_code !== 'PENDENTE')
                                    <button onclick="copyToClipboard('gift-code-{{ $item->id }}', this)" class="gift-code-btn-copy">
                                        <i class="fas fa-copy"></i> Copiar
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @else
                        <div class="alert-box info" role="alert">
                            <i class="fas fa-hourglass-start"></i>
                            <div>Os códigos serão liberados assim que o pedido for concluído.</div>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="w-full lg:w-5/12 px-3">
            <div class="main-card-tokenstore">
                <div class="main-card-header-tokenstore">
                    <i class="fas fa-receipt"></i>
                    <h5>Resumo da Compra</h5>
                </div>
                <div class="main-card-body-tokenstore">
                    <div class="summary-line"><span>ID do Pedido:</span> <span>#{{ $order->id }}</span></div>
                    <div class="summary-line"><span>Data:</span> <span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                    <div class="summary-line">
                        <span>Status:</span>
                        <span>
                            @if($order->status === 'completed') <span class="status-pill success">Concluído</span>
                            @elseif($order->status === 'processing') <span class="status-pill warning">Processando</span>
                            @elseif($order->status === 'pending') <span class="status-pill info">Pendente</span>
                            @else <span class="status-pill danger">{{ ucfirst($order->status) }}</span>
                            @endif
                        </span>
                    </div>
                    <div class="summary-line"><span>Método Pag.:</span> <span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span></div>
                    <div class="summary-line">
                        <span>Status Pag.:</span>
                        <span>
                            @if($order->payment_status === 'paid') <span class="status-pill success">Pago</span>
                            @elseif($order->payment_status === 'pending') <span class="status-pill warning">Pendente</span>
                            @else <span class="status-pill danger">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </span>
                    </div>
                    <div class="summary-divider-line"></div>
                    <div class="summary-line"><span>Subtotal:</span> <span>R$ {{ number_format($order->total, 2, ',', '.') }}</span></div>
                    <div class="summary-line"><span>Taxas:</span> <span>R$ 0,00</span></div>
                    <div class="summary-divider-line"></div>
                    <div class="summary-line total">
                        <span class="font-bold">Total:</span>
                        <span class="value font-bold">R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="main-card-tokenstore">
                <div class="main-card-header-tokenstore">
                     <i class="fas fa-question-circle"></i>
                    <h5>Precisa de Ajuda?</h5>
                </div>
                <div class="main-card-body-tokenstore text-center">
                    <p class="text-[var(--ts-text-medium)] mb-4 text-sm">Em caso de dúvidas ou problemas com seu pedido, fale conosco.</p>
                    <a href="#" id="simulateSupportButton" class="btn-ts primary w-full">                        
                        <i class="fas fa-headset"></i> Contatar Suporte
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard(elementId, buttonElement) {
        const element = document.getElementById(elementId);
        if (element) {
            const textToCopy = element.innerText || element.textContent;
            if (textToCopy === 'PENDENTE') return;

            navigator.clipboard.writeText(textToCopy).then(function() {
                const originalHTML = buttonElement.innerHTML;
                buttonElement.innerHTML = '<i class="fas fa-check"></i> Copiado';
                buttonElement.disabled = true;
                setTimeout(() => {
                    buttonElement.innerHTML = originalHTML;
                    buttonElement.disabled = false;
                }, 2500);
            }, function(err) {
                console.error('Falha ao copiar: ', err);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const supportButton = document.getElementById('simulateSupportButton');
        let emailSent = false; // Flag para rastrear se o email foi enviado

        if (supportButton) {
            supportButton.addEventListener('click', function(event) {
                event.preventDefault();
                
                if (emailSent) {
                    alert('O e-mail de suporte para este pedido já foi solicitado.');
                    return; 
                }
                
                alert('Solicitação de suporte enviada para o pedido numero: #{{ $order->id }}.\nVerifique seu email, se nao achar procure no Spam.');
                
                this.innerHTML = '<i class="fas fa-check-circle"></i> Email enviado!';
                this.disabled = true; 
                emailSent = true; 
            });
        }
    });
</script>
@endpush
@endsection