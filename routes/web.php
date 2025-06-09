<?php

use Illuminate\Support\Facades\Route;
// Removido: use Illuminate\Support\Facades\Auth; // Não é necessário se você não usa Auth::routes() diretamente
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\AuthController; // Seu controller de login/registro
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AccountController;

// Admin Controllers
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// NOVO: Importar os controllers de reset de senha
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categoria/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::get('/produtos/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/search', [ProductController::class, 'search'])->name('products.search');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // ROTAS PARA "ESQUECI MINHA SENHA?" ADICIONADAS AQUI
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update'); // Frequentemente nomeada como 'password.update'
});


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
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    
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
    
    Route::resource('users', AdminUserController::class)->except(['show']);
    Route::patch('users/{user}/toggle-active', [AdminUserController::class, 'toggleActiveStatus'])->name('users.toggle-active');
});

Route::fallback(function () {
    return redirect()->route('home');
});