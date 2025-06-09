<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
// Removido Http e Log por enquanto para simplificar, podem ser adicionados de volta se necessário
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;
// use Exception;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('category')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($catQ) use ($search) {
                      $catQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $products = $query->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $product = new Product(); // Para passar um objeto produto vazio para o form se necessário
        // Definições padrão podem ser feitas no _form ou aqui, se desejar
        // $product->is_active = true;
        // $product->is_featured = false;
        return view('admin.products.create', compact('categories', 'product'));
    }

    public function store(Request $request)
    {
        // Log para ver todos os dados da requisição ao criar (para depuração)
        // \Log::info('Store Request Data:', $request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean', // Adicionada validação
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Mudado para image_upload
            // Removida validação para image_url_input
        ]);

        $data = $validatedData; // Começa com os dados validados
        // Remove o campo de upload do array $data, pois não queremos salvá-lo diretamente no banco
        unset($data['image_upload']);


        $data['slug'] = Str::slug($request->name);
        // Converte para booleano, tratando caso o campo não venha (checkbox não marcado)
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');


        if ($request->hasFile('image_upload')) { // <<< MUDANÇA AQUI
            $imageFile = $request->file('image_upload'); // <<< MUDANÇA AQUI
            // Gera um nome de arquivo único, mantendo a extensão original
            $fileName = Str::random(20) . '_' . time() . '.' . $imageFile->getClientOriginalExtension();
            // Armazena na pasta 'public/products' e obtém o caminho relativo
            $path = $imageFile->storeAs('products', $fileName, 'public'); // 'public' é o disk
            $data['image_path'] = $path; // Salva 'products/nome_arquivo.jpg' no banco
        } else {
            $data['image_path'] = null; // Garante que seja null se nenhum arquivo for enviado
        }

        // Log para ver os dados que serão criados (para depuração)
        // \Log::info('Data to be created:', $data);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Log para ver todos os dados da requisição ao atualizar (para depuração)
        // \Log::info('Update Request Data for Product ID ' . $product->id . ':', $request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean', // Adicionada validação
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Mudado para image_upload
            'remove_image' => 'nullable|boolean', // Para a checkbox de remover imagem
            // Removida validação para image_url_input
        ]);

        $data = $validatedData;
        unset($data['image_upload']); // Não queremos salvar 'image_upload' diretamente
        unset($data['remove_image']); // Nem 'remove_image'

        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');


        // Lógica para remover imagem antiga se a checkbox 'remove_image' estiver marcada
        if ($request->boolean('remove_image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = null; // Define como null no banco
        }

        // Lógica para nova imagem (APENAS se 'remove_image' não foi marcada e um novo arquivo foi enviado)
        if (!$request->boolean('remove_image') && $request->hasFile('image_upload')) { // <<< MUDANÇA AQUI
            // Remove a imagem antiga se uma nova for enviada e a antiga existir
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $imageFile = $request->file('image_upload'); // <<< MUDANÇA AQUI
            $fileName = Str::random(20) . '_' . time() . '.' . $imageFile->getClientOriginalExtension();
            $path = $imageFile->storeAs('products', $fileName, 'public');
            $data['image_path'] = $path; // Salva o novo caminho
        }
        // Se remove_image não foi marcado e nenhuma nova imagem foi enviada,
        // o campo 'image_path' do produto existente não é alterado (a menos que já tenha sido setado para null pela lógica de remoção)
        // Se remove_image foi marcado, $data['image_path'] já é null.

        // Log para ver os dados que serão atualizados (para depuração)
        // \Log::info('Data to be updated for Product ID ' . $product->id . ':', $data);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    // Removido o método getImageExtensionFromResponse pois não estamos mais baixando de URL

    public function destroy(Product $product)
    {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produto excluído com sucesso!');
    }
}