<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FornecedorController;

// ============ ROTAS PÚBLICAS ============
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ============ AUTENTICAÇÃO ============
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ============ ROTAS DO SISTEMA ============
Route::get('/scan', [ScanController::class, 'index'])->name('scan');
Route::post('/scan', [ScanController::class, 'store'])->name('scan.store');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/order/success/{orderId}', function ($orderId) {
    return view('order-success', compact('orderId'));
})->name('order.success');

// ============ ROTAS FUTURAS ============
use Laravel\Socialite\Facades\Socialite;
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// ============ PAINEL ADMIN (protegido) ============
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Clientes - CRUD Completo
    Route::get('/clientes', [AdminController::class, 'clientes'])->name('clientes');
    Route::get('/clientes/create', [AdminController::class, 'createCliente'])->name('clientes.create');
    Route::post('/clientes', [AdminController::class, 'storeCliente'])->name('clientes.store');
    Route::get('/clientes/{id}/edit', [AdminController::class, 'editCliente'])->name('clientes.edit');
    Route::put('/clientes/{id}', [AdminController::class, 'updateCliente'])->name('clientes.update');
    Route::delete('/clientes/{id}', [AdminController::class, 'deleteCliente'])->name('clientes.delete');

    // Fornecedores - CRUD Completo
    Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores');
    Route::get('/fornecedores/create', [FornecedorController::class, 'create'])->name('fornecedores.create');
    Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store');
    Route::get('/fornecedores/{id}/edit', [FornecedorController::class, 'edit'])->name('fornecedores.edit');
    Route::put('/fornecedores/{id}', [FornecedorController::class, 'update'])->name('fornecedores.update');
    Route::delete('/fornecedores/{id}', [FornecedorController::class, 'destroy'])->name('fornecedores.destroy');

    // Buscar cidades via AJAX
    Route::get('/buscar-cidades', [AdminController::class, 'buscarCidades'])->name('buscar.cidades');
});