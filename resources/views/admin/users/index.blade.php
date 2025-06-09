@extends('layouts.app')

@section('title', 'Gerenciar Usuários - TokenStore')

@push('styles')
<style>
    /* ... (todos os seus estilos anteriores permanecem aqui, incluindo :root e outros) ... */
    :root {
        --primary-purple-rgb: 138, 43, 226;
        --primary-cyan-rgb: 0, 255, 255;
        --primary-magenta-rgb: 255, 0, 255;
        --text-muted-rgb: 200, 200, 210;
        --dark-bg-rgb: 10, 10, 10;
        --color-green-rgb: 34, 197, 94; 
        --color-yellow-rgb: 245, 158, 11; 
        --color-gray-rgb: 107, 114, 128; 
    }
    .badge.ts-badge-active, .badge.ts-badge-inactive {
        padding: 0.5em 0.9em;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: 1px solid transparent;
    }
    .badge.ts-badge-active {
        background: linear-gradient(135deg, rgba(var(--color-green-rgb),1), rgba(var(--color-green-rgb),0.7));
        color: var(--dark-bg);
        box-shadow: 0 0 12px rgba(var(--color-green-rgb), 0.5), 0 0 5px rgba(var(--color-green-rgb), 0.3) inset;
        border-color: rgba(var(--color-green-rgb), 0.7);
    }
    .badge.ts-badge-inactive {
        background-color: rgba(var(--color-gray-rgb), 0.4);
        color: var(--text-secondary);
        border: 1px solid rgba(var(--color-gray-rgb), 0.5);
        box-shadow: 0 0 8px rgba(var(--color-gray-rgb), 0.2) inset;
    }
    .table.tokenstore-table .btn-ts.success {
        background: transparent;
        color: rgb(var(--color-green-rgb));
        border: 1px solid rgb(var(--color-green-rgb));
        box-shadow: 0 0 8px rgba(var(--color-green-rgb), 0.3);
    }
    .table.tokenstore-table .btn-ts.success:hover {
        background: rgba(var(--color-green-rgb), 0.2);
        box-shadow: 0 0 15px rgba(var(--color-green-rgb), 0.5), 0 0 5px rgb(var(--color-green-rgb)) inset;
        color: #fff;
        transform: translateY(-1px);
    }
    .table.tokenstore-table .btn-ts.warning {
        background: transparent;
        color: rgb(var(--color-yellow-rgb));
        border: 1px solid rgb(var(--color-yellow-rgb));
        box-shadow: 0 0 8px rgba(var(--color-yellow-rgb), 0.3);
    }
    .table.tokenstore-table .btn-ts.warning:hover {
        background: rgba(var(--color-yellow-rgb), 0.2);
        box-shadow: 0 0 15px rgba(var(--color-yellow-rgb), 0.5), 0 0 5px rgb(var(--color-yellow-rgb)) inset;
        color: #fff;
        transform: translateY(-1px);
    }
    .page-title-tokenstore { font-size: 2.25rem; font-weight: 800; margin-bottom: 0rem; color: var(--text-primary); text-shadow: 0 0 8px rgba(var(--primary-purple-rgb), 0.5); }
    .page-title-tokenstore span { color: var(--primary-cyan); }
    .users-table-container.tokenstore-style { background-color: var(--glass-bg); backdrop-filter: blur(15px); padding: 2rem 2.5rem; border-radius: 16px; border: 1px solid var(--glass-border); box-shadow: 0 10px 40px rgba(var(--dark-bg-rgb), 0.5), 0 0 0 1px rgba(var(--primary-purple-rgb),0.3); position: relative; }
    .users-table-container.tokenstore-style::before { content: ''; position: absolute; inset: -1px; border-radius: 17px; background: linear-gradient(145deg, rgba(var(--primary-purple-rgb), 0.4), rgba(var(--primary-cyan-rgb), 0.4), rgba(var(--primary-magenta-rgb), 0.4)); z-index: -1; filter: blur(8px); opacity: 0.7; }
    .tokenstore-table-wrapper { border-radius: 10px; overflow: hidden; border: 1px solid rgba(var(--primary-purple-rgb), 0.2); margin-top: 1.5rem; }
    .table.tokenstore-table { width: 100%; border-collapse: separate; border-spacing: 0; color: var(--text-secondary); font-size: 0.9rem; background-color: rgba(var(--dark-bg-rgb), 0.3); }
    .table.tokenstore-table thead th { background-color: rgba(var(--primary-purple-rgb), 0.25); color: var(--primary-cyan); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; padding: 1rem 1.25rem; text-align: left; border-bottom: 2px solid var(--primary-purple); }
    .table.tokenstore-table tbody tr { background-color: transparent; transition: background-color 0.3s ease, box-shadow 0.3s ease; }
    .table.tokenstore-table tbody tr:hover { background-color: rgba(var(--glass-border), 0.5); box-shadow: inset 0 0 15px rgba(var(--primary-cyan-rgb), 0.1); }
    .table.tokenstore-table tbody td { padding: 0.9rem 1.25rem; vertical-align: middle; border-bottom: 1px solid var(--glass-border); }
    .table.tokenstore-table tbody tr:last-child td { border-bottom: none; }
    .badge.ts-badge-yes, .badge.ts-badge-no { padding: 0.5em 0.9em; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid transparent; }
    .badge.ts-badge-yes { background: linear-gradient(135deg, var(--primary-cyan), #1ddcb5); color: var(--dark-bg); box-shadow: 0 0 12px rgba(var(--primary-cyan-rgb), 0.5), 0 0 5px rgba(var(--primary-cyan-rgb), 0.3) inset; border-color: rgba(var(--primary-cyan-rgb), 0.7); }
    .badge.ts-badge-no { background-color: rgba(var(--text-muted-rgb), 0.15); color: var(--text-secondary); border: 1px solid rgba(var(--text-muted-rgb), 0.3); box-shadow: 0 0 8px rgba(var(--text-muted-rgb), 0.2) inset; }
    .actions-cell { min-width: 160px; /* Ajustado para mais espaço -- mais botões */ text-align: right; }
    .table.tokenstore-table .btn-ts { padding: 0.5rem 0.75rem; font-size: 0.8rem; border-radius: 8px; margin-left: 0.3rem; line-height: 1.2; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s ease-in-out; position: relative; overflow: hidden; }
    .table.tokenstore-table .btn-ts.icon-only { padding: 0.5rem; width: 32px; height: 32px; }
    .table.tokenstore-table .btn-ts.icon-only i { margin-right: 0; font-size: 0.9rem; }
    .table.tokenstore-table .btn-ts.primary-cyan { background: transparent; color: var(--primary-cyan); border: 1px solid var(--primary-cyan); box-shadow: 0 0 8px rgba(var(--primary-cyan-rgb), 0.3); }
    .table.tokenstore-table .btn-ts.primary-cyan:hover { background: rgba(var(--primary-cyan-rgb), 0.2); box-shadow: 0 0 15px rgba(var(--primary-cyan-rgb), 0.5), 0 0 5px var(--primary-cyan) inset; color: #fff; transform: translateY(-1px); }
    .table.tokenstore-table .btn-ts.danger { background: transparent; color: var(--primary-magenta); border: 1px solid var(--primary-magenta); box-shadow: 0 0 8px rgba(var(--primary-magenta-rgb), 0.3); }
    .table.tokenstore-table .btn-ts.danger:hover { background: rgba(var(--primary-magenta-rgb), 0.2); box-shadow: 0 0 15px rgba(var(--primary-magenta-rgb), 0.5), 0 0 5px var(--primary-magenta) inset; color: #fff; transform: translateY(-1px); }
    .tokenstore-alert { background-color: var(--glass-bg); backdrop-filter: blur(10px); border: 1px solid var(--glass-border); color: var(--text-primary); margin-bottom: 1.5rem; }
    .tokenstore-alert.alert-success { border-left: 5px solid var(--primary-cyan); box-shadow: 0 4px 15px rgba(var(--primary-cyan-rgb), 0.1); }
    .tokenstore-alert.alert-danger { border-left: 5px solid var(--primary-magenta); box-shadow: 0 4px 15px rgba(var(--primary-magenta-rgb), 0.1); }
    .tokenstore-alert .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
    .pagination-wrapper .pagination { justify-content: center; }
    .pagination-wrapper .page-item .page-link { background-color: var(--glass-bg); border: 1px solid var(--glass-border); color: var(--text-secondary); margin: 0 3px; border-radius: 6px; transition: all 0.3s ease; }
    .pagination-wrapper .page-item.active .page-link { background: linear-gradient(135deg, var(--primary-purple), var(--primary-magenta)); border-color: var(--primary-magenta); color: var(--text-primary); box-shadow: 0 0 10px rgba(var(--primary-magenta-rgb), 0.4); }
    .pagination-wrapper .page-item:not(.active) .page-link:hover { background-color: rgba(var(--primary-cyan-rgb), 0.15); border-color: var(--primary-cyan); color: var(--primary-cyan); }
    .pagination-wrapper .page-item.disabled .page-link { background-color: rgba(var(--glass-bg), 0.5); border-color: var(--glass-border); color: var(--text-muted); opacity: 0.6; }
    .btn-ts.primary { background: linear-gradient(135deg, var(--primary-purple), var(--primary-magenta)); color: white; border: 1px solid transparent; padding: 0.75rem 1.5rem; font-weight: 600; border-radius: 50px; text-decoration: none; transition: all 0.3s ease; }
    .btn-ts.primary:hover { opacity: 0.9; box-shadow: 0 5px 15px rgba(var(--primary-magenta-rgb), 0.4); transform: translateY(-2px); }
    .btn-ts.primary i { margin-right: 0.5rem; }
    /* Estilo para botões de navegação no cabeçalho da tabela */
    .admin-header-buttons .btn {
        font-size: 0.85rem; /* Tamanho um pouco menor */
        padding: 0.5rem 1rem;
    }
    .admin-header-buttons .btn i {
        font-size: 0.8rem; /* Ícone um pouco menor */
    }

</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="users-table-container tokenstore-style">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title-tokenstore"><span>Gerenciar</span> Usuários</h1>
            <div class="admin-header-buttons"> {{-- Div para agrupar os botões --}}
                {{-- BOTÃO DE VOLTAR PARA O PAINEL DO ADMIN --}}
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Painel
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-ts primary">
                    <i class="fas fa-plus"></i> Novo Usuário
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show tokenstore-alert" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
             <div class="alert alert-danger alert-dismissible fade show tokenstore-alert" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive tokenstore-table-wrapper">
            <table class="table tokenstore-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Admin</th>
                        <th>Status</th>
                        <th>Criado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge ts-badge-yes">Sim</span>
                            @else
                                <span class="badge ts-badge-no">Não</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge ts-badge-active">Ativo</span>
                            @else
                                <span class="badge ts-badge-inactive">Inativo</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td class="actions-cell">
                            <form action="{{ route('admin.users.toggle-active', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('PATCH')
                                @if($user->is_active)
                                    <button type="submit" class="btn-ts icon-only warning" title="Desativar Usuário">
                                        <i class="fas fa-user-slash"></i>
                                    </button>
                                @else
                                    <button type="submit" class="btn-ts icon-only success" title="Ativar Usuário">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                @endif
                            </form>

                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-ts icon-only primary-cyan" title="Editar Usuário">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-ts icon-only danger" title="Excluir Usuário">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Nenhum usuário encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($users->hasPages())
            <div class="pagination-wrapper mt-4">
                {{ $users->links() }}
            </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
{{-- Seus scripts aqui, se houver --}}
@endpush