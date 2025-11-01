<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;

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
Route::get('/forgot-password', function () {
    return redirect()->route('login')->with('info', 'Funcionalidade em desenvolvimento');
})->name('password.request');

Route::get('/auth/google', function () {
    return redirect()->route('login')->with('info', 'Login social em desenvolvimento');
})->name('auth.google');

Route::get('/auth/facebook', function () {
    return redirect()->route('login')->with('info', 'Login social em desenvolvimento');
})->name('auth.facebook');