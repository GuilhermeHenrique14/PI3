@extends('layouts.app')

@section('title', 'Meus Pedidos - TokenStore')

@push('styles')
<style>
    :root {
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
    }

    body {
        background-color: var(--ts-bg-main) !important;
        font-family: 'Inter', sans-serif;
    }

    .readable-container { color: var(--ts-text-light); }
    .page-title-tokenstore {
        font-size: 2.25rem; font-weight: 800; margin-bottom: 2rem;
        color: var(--ts-text-light);
        text-shadow: 0 0 8px rgba(var(--ts-purple-rgb), 0.5);
    }
    .page-title-tokenstore span { color: var(--ts-cyan); }

    .order-list-card {
        background-color: var(--ts-card-bg);
        border: 1px solid var(--ts-card-border);
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
        padding: 1.5rem;
        transition: border-color 0.3s ease, transform 0.2s ease;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .order-list-card:hover { border-color: var(--ts-cyan); transform: translateY(-3px); }

    .order-card-header {
        display: flex; justify-content: space-between; align-items: center;
        border-bottom: 1px solid rgba(var(--ts-purple-rgb), 0.2);
        padding-bottom: 0.75rem; margin-bottom: 0.75rem;
    }
    .order-card-id { font-size: 1.125rem; font-weight: 700; color: var(--ts-purple-light); }
    .order-card-date { font-size: 0.875rem; color: var(--ts-text-medium); }

    .order-card-body {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem; align-items: center;
    }
    .order-info-item { font-size: 0.9rem; }
    .order-info-item strong {
        color: var(--ts-text-medium); display: block; font-weight: 500;
        margin-bottom: 0.15rem; font-size: 0.8rem;
    }
    .order-info-item .value { font-weight: 600; }

    .order-card-items-preview {
        font-size: 0.875rem; color: var(--ts-text-medium);
        margin-top: 0.75rem; padding-top: 0.75rem;
        border-top: 1px solid rgba(var(--ts-purple-rgb), 0.15);
    }
    .order-card-items-preview strong {
        color: var(--ts-text-light); font-weight: 600;
        display: block; margin-bottom: 0.5rem;
    }
    .order-card-items-preview ul { list-style: none; padding-left: 0; margin-bottom: 0; }
    .order-card-items-preview ul li {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    .item-preview-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 0.75rem;
        border: 1px solid rgba(var(--ts-cyan-rgb), 0.2);
        background-color: rgba(var(--ts-cyan-rgb), 0.05); /* Leve fundo para placeholders */
    }
    .item-preview-details {
        flex-grow: 1;
    }
    .item-preview-details .item-name {
        color: var(--ts-text-light);
        font-weight: 500;
        display: block;
    }
    .item-preview-details .item-quantity {
        font-size: 0.8rem;
        color: var(--ts-text-medium);
    }

    .order-card-items-preview .more-items-link {
        font-style: italic; color: var(--ts-purple-light); font-size: 0.8rem;
        margin-top: 0.35rem; display: inline-block; text-decoration: none;
    }
    .order-card-items-preview .more-items-link:hover { text-decoration: underline; color: var(--ts-cyan); }

    .order-card-footer {
        margin-top: 1rem; text-align: right;
    }
    .btn-ts {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0.625rem 1.25rem; border-radius: 8px;
        font-weight: 600; font-size: 0.875rem;
        transition: all 0.2s ease; border: 1px solid transparent; cursor: pointer;
    }
    .btn-ts.primary {
        background: linear-gradient(to right, var(--ts-purple), var(--ts-magenta));
        color: white; box-shadow: 0 2px 4px rgba(var(--ts-purple-rgb), 0.3);
    }
    .btn-ts.primary:hover { opacity: 0.9; box-shadow: 0 4px 8px rgba(var(--ts-magenta-rgb), 0.4); }
    .btn-ts.outline {
        background-color: transparent; color: var(--ts-cyan); border-color: var(--ts-cyan);
    }
    .btn-ts.outline:hover { background-color: rgba(var(--ts-cyan-rgb), 0.1); }
    .btn-ts i { margin-right: 0.5rem; }

    .status-pill {
        padding: 0.25rem 0.75rem; border-radius: 50px;
        font-size: 0.75rem; font-weight: 600; text-transform: capitalize;
        display: inline-block;
    }
    .status-pill.success { background-color: #16a34a; color: white; }
    .status-pill.warning { background-color: #d97706; color: white; }
    .status-pill.info    { background-color: var(--ts-blue) ; color: white; }
    .status-pill.danger  { background-color: #dc2626; color: white; }

    .pagination-tokenstore nav {
        display: flex; justify-content: center; margin-top: 2rem;
    }
    .pagination-tokenstore .pagination {
        display: flex; padding-left: 0; list-style: none; border-radius: 0.375rem;
    }
    .pagination-tokenstore .page-item .page-link {
        position: relative; display: block; padding: 0.5rem 0.75rem; margin-left: -1px;
        line-height: 1.25; color: var(--ts-cyan); background-color: var(--ts-card-bg);
        border: 1px solid var(--ts-card-border); transition: all 0.2s ease;
    }
    .pagination-tokenstore .page-item:first-child .page-link {
        margin-left: 0; border-top-left-radius: 0.375rem; border-bottom-left-radius: 0.375rem;
    }
    .pagination-tokenstore .page-item:last-child .page-link {
        border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem;
    }
    .pagination-tokenstore .page-item.active .page-link {
        z-index: 3; color: white; background-color: var(--ts-purple); border-color: var(--ts-purple);
    }
    .pagination-tokenstore .page-item:hover .page-link {
        color: var(--ts-text-light); background-color: var(--ts-card-header-bg);
        border-color: var(--ts-purple-light);
    }
    .pagination-tokenstore .page-item.disabled .page-link {
        color: var(--ts-text-medium); pointer-events: none; background-color: var(--ts-card-bg);
        border-color: var(--ts-card-border); opacity: 0.6;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto p-4 md:p-6 readable-container">
    <h1 class="page-title-tokenstore">Meus <span>Pedidos</span></h1>

    @if(isset($orders) && $orders->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-1 gap-0">
            @foreach($orders as $order)
                <div class="order-list-card">
                    <div class="order-card-header">
                        <span class="order-card-id">Pedido #{{ $order->id }}</span>
                        <span class="order-card-date">{{ $order->created_at->format('d/m/Y \à\s H:i') }}</span>
                    </div>

                    <div class="order-card-body">
                        <div class="order-info-item">
                            <strong>Status do Pedido:</strong>
                            <span class="value">
                                @if($order->status === 'completed') <span class="status-pill success">Concluído</span>
                                @elseif($order->status === 'processing') <span class="status-pill warning">Processando</span>
                                @elseif($order->status === 'pending') <span class="status-pill info">Pendente</span>
                                @else <span class="status-pill danger">{{ ucfirst($order->status) }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="order-info-item">
                            <strong>Status do Pagamento:</strong>
                            <span class="value">
                                @if($order->payment_status === 'paid') <span class="status-pill success">Pago</span>
                                @elseif($order->payment_status === 'pending') <span class="status-pill warning">Pendente</span>
                                @else <span class="status-pill danger">{{ ucfirst($order->payment_status) }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="order-info-item">
                            <strong>Total:</strong>
                            <span class="value" style="color: var(--ts-cyan);">R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="order-card-items-preview">
                        <strong>Itens Inclusos:</strong>
                        @if($order->items->isNotEmpty())
                            <ul>
                                @php $itemLimit = 2; @endphp
                                @foreach($order->items->take($itemLimit) as $item)
                                    <li>
                                        @if($item->product)
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="item-preview-image">
                                            <div class="item-preview-details">
                                                <span class="item-name">{{ Str::limit($item->product->name, 30) }}</span>
                                                <span class="item-quantity">(x{{ $item->quantity }})</span>
                                            </div>
                                        @else
                                            <img src="{{ asset('images/default-product.png') }}" alt="Item indisponível" class="item-preview-image">
                                            <div class="item-preview-details">
                                                <span class="item-name">Item indisponível</span>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            @if($order->items->count() > $itemLimit)
                                <a href="{{ route('orders.show', $order->id) }}" class="more-items-link">
                                    e +{{ $order->items->count() - $itemLimit }} outro(s) item(ns) - Ver todos
                                </a>
                            @endif
                        @else
                            <p class="text-xs text-[var(--ts-text-medium)]">Nenhum item neste pedido.</p>
                        @endif
                    </div>

                    <div class="order-card-footer">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn-ts primary text-sm">
                            <i class="fas fa-eye"></i> Ver Detalhes Completos
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($orders->hasPages())
            <div class="mt-8 pagination-tokenstore">
                {{ $orders->links() }}
            </div>
        @endif

    @else
         <div class="text-center py-10 bg-[var(--ts-card-bg)] rounded-xl border border-[var(--ts-card-border)]">
            <i class="fas fa-box-open fa-3x text-[var(--ts-text-medium)] mb-3"></i>
            <p class="text-xl font-semibold text-[var(--ts-text-light)]">Você ainda não fez nenhum pedido.</p>
            <p class="text-[var(--ts-text-medium)]">Que tal explorar nossa loja?</p>
            <a href="{{ route('home') }}" class="btn-ts primary mt-4">
                <i class="fas fa-store"></i> Ir para Loja
            </a>
        </div>
    @endif
</div>
@endsection