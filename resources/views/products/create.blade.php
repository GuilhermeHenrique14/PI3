@extends('layouts.app')

@section('title', 'Admin: Novo Produto - TokenStore')

@section('content')
<div class="container mt-5 mb-5">
    <h1 class="section-title mb-4" style="font-size: 2.5rem;">Novo Produto</h1>
    
    {{-- Inclua aqui seu partial de erros de formulário, se tiver um. Ex: @include('partials.form-errors') --}}
    {{-- Se você não tiver um, os erros de validação individuais aparecerão abaixo de cada campo se configurado no _form --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
          style="background-color: var(--glass-bg); border: 1px solid var(--glass-border); padding: 2rem; border-radius: 0.5rem;">
        {{-- _form espera 'product' e 'categories' --}}
        {{-- A variável $product é passada do controller (new Product()) --}}
        {{-- A variável $categories é passada do controller --}}
        @include('admin.products._form', ['product' => $product, 'categories' => $categories])
    </form>
</div>
@endsection