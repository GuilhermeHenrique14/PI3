@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: rgba(var(--primary-cyan-rgb), 0.2); border-color: var(--primary-cyan); color: var(--primary-cyan);">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: rgba(var(--primary-magenta-rgb), 0.2); border-color: var(--primary-magenta); color: var(--primary-magenta);">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif