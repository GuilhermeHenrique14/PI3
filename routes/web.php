<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AccountController;

// Admin Controllers
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController; // Seu UserController já está aqui

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categoria/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::get('/produtos/{product:slug}', [ProductController::class, 'show'])->name('products.show'); // Mantido product:slug

Route::get('/search', [ProductController::class, 'search'])->name('products.search');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Removido Auth::routes() pois você tem rotas customizadas com AuthController
// Se precisar de reset de senha, você teria que adicionar as rotas manualmente ou usar o Laravel UI/Fortify

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    // Rotas do Carrinho
    Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrinho/adicionar', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/carrinho/atualizar/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/carrinho/remover/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/carrinho/limpar', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/carrinho/update-quantity-ajax', [CartController::class, 'updateQuantityAjax'])->name('cart.update.quantity.ajax');

    // Rota de Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout'); // Alterado para get, se for só para exibir
    // Se checkout também processa, você pode precisar de uma rota POST separada para CheckoutController@store ou @process
    
    // Rotas de Pedidos (Orders)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/confirmation/{order}', [OrderController::class, 'confirmation'])->name('confirmation');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });

    // Rotas para Minha Conta e Edição de Perfil
    Route::get('/minha-conta', [AccountController::class, 'index'])->name('account.index');
    Route::get('/minha-conta/editar-perfil', [AccountController::class, 'editProfile'])->name('account.edit-profile');
    Route::put('/minha-conta/atualizar-perfil', [AccountController::class, 'updateProfile'])->name('account.update-profile');
    Route::put('/minha-conta/atualizar-senha', [AccountController::class, 'updatePassword'])->name('account.update-password');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    
    // Rotas para Usuários (Admin)
    Route::resource('users', AdminUserController::class)->except(['show']);
    // NOVA ROTA PARA ALTERNAR O STATUS ATIVO/INATIVO DO USUÁRIO
    Route::patch('users/{user}/toggle-active', [AdminUserController::class, 'toggleActiveStatus'])->name('users.toggle-active');
});

Route::fallback(function () {
    return redirect()->route('home');
});