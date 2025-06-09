@if ($errors->any())
    <div class="alert alert-danger mb-4" role="alert" style="background-color: rgba(var(--primary-magenta-rgb), 0.2); border-color: var(--primary-magenta); color: var(--primary-magenta);">
        <strong class="d-block">Oops! Algo deu errado.</strong>
        <ul class="mt-2 mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif