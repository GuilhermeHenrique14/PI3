@csrf
<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="name" class="form-label" style="color: var(--text-primary);">Nome do Produto</label>
            <input type="text" class="form-control admin-form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label" style="color: var(--text-primary);">Descrição</label>
            <textarea class="form-control admin-form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label" style="color: var(--text-primary);">Preço (R$)</label>
                <input type="number" step="0.01" class="form-control admin-form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price ?? '0.00') }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="stock" class="form-label" style="color: var(--text-primary);">Estoque</label>
                <input type="number" class="form-control admin-form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required>
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="category_id" class="form-label" style="color: var(--text-primary);">Categoria</label>
            <select class="form-select admin-form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                <option value="">Selecione uma categoria</option>
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(old('category_id', $product->category_id ?? '') == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                @else
                    <option value="" disabled>Nenhuma categoria encontrada</option>
                @endif
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo de Upload de Imagem --}}
        <div class="mb-3">
            <label for="image_upload" class="form-label" style="color: var(--text-primary);">Imagem do Produto</label>
            <input type="file" class="form-control admin-form-control @error('image_upload') is-invalid @enderror" id="image_upload" name="image_upload" accept="image/*">
            @error('image_upload')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- Exibir imagem atual se estiver editando e ela existir --}}
            @if(isset($product) && $product->image_url)
                <div class="mt-2">
                    <label style="color: var(--text-secondary); font-size: 0.9em;">Imagem Atual:</label><br>
                    <img src="{{ $product->image_url }}" alt="Imagem atual de {{ $product->name }}" class="img-thumbnail mt-1" width="150" style="background-color: var(--dark-secondary); border-color: var(--glass-border);">
                    {{-- Checkbox para remover imagem atual (APENAS no modo de edição) --}}
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                        <label class="form-check-label" for="remove_image" style="color: var(--text-primary); font-size: 0.9em;">
                            Remover imagem atual
                        </label>
                    </div>
                </div>
            @endif
        </div>

        {{-- REMOVIDO O CAMPO de input de URL da Imagem --}}
        {{--
        <div class="mb-3">
            <label for="image_url_input" class="form-label" style="color: var(--text-primary);">Ou URL da Imagem (Colar)</label>
            <input type="url" class="form-control admin-form-control @error('image_url_input') is-invalid @enderror" id="image_url_input" name="image_url_input" placeholder="https://exemplo.com/imagem.jpg" value="{{ old('image_url_input') }}">
            @error('image_url_input')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text" style="color: var(--text-secondary);">Se preenchido e nenhum arquivo for enviado acima, esta URL será usada.</small>
        </div>
        --}}

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active"
                   @if(old('is_active') !== null)
                       {{ old('is_active') ? 'checked' : '' }}
                   @elseif(isset($product) && $product->exists)
                       {{ $product->is_active ? 'checked' : '' }}
                   @else
                       checked {{-- Padrão para 'checked' ao criar novo produto --}}
                   @endif
            >
            <label class="form-check-label" for="is_active" style="color: var(--text-primary);">
                Produto Ativo
            </label>
            @error('is_active')
                <div class="invalid-feedback d-block">{{ $message }}</div> {{-- d-block para forçar exibição --}}
            @enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="1" id="is_featured" name="is_featured"
                   @if(old('is_featured') !== null)
                       {{ old('is_featured') ? 'checked' : '' }}
                   @elseif(isset($product))
                       {{ $product->is_featured ? 'checked' : '' }}
                   @endif
            >
            <label class="form-check-label" for="is_featured" style="color: var(--text-primary);">
                Produto em Destaque
            </label>
            @error('is_featured')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn hero-cta me-2">{{ (isset($product) && $product->exists) ? 'Atualizar Produto' : 'Criar Produto' }}</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary" style="background-color: var(--dark-secondary); border-color: var(--glass-border); color: var(--text-secondary);">Cancelar</a>
</div>

@pushOnce('styles')
<style>
    .admin-form-control {
        background-color: var(--dark-secondary) !important;
        color: var(--text-primary) !important;
        border: 1px solid var(--glass-border) !important;
    }
    .admin-form-control:focus {
        border-color: var(--primary-cyan) !important;
        box-shadow: 0 0 0 0.25rem rgba(0, 255, 255, 0.25) !important; /* Usei 0,255,255 para primary-cyan-rgb */
    }
    .form-select.admin-form-control {
        /* Mantive o seu SVG de seta, parece bom */
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23dee2e6' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
    }
    .form-check-input:checked {
        background-color: var(--primary-cyan);
        border-color: var(--primary-cyan);
    }
    .form-check-input {
        background-color: var(--dark-secondary);
        border-color: var(--glass-border);
    }
    .invalid-feedback {
        display: block; /* Garante que o feedback de erro seja sempre visível se houver um erro */
    }
</style>
@endPushOnce