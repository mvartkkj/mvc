<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $tableCode = session('table_code', 'Mesa 12');
        
        // Mock só pra visualizar - em produção, pegar da sessão
        $cartItems = [
            ['id' => 1, 'name' => 'Picanha na Brasa', 'price' => 89.90, 'quantity' => 1],
            ['id' => 5, 'name' => 'Espaguete Carbonara', 'price' => 54.90, 'quantity' => 2],
            ['id' => 9, 'name' => 'Refrigerante Lata', 'price' => 6.90, 'quantity' => 2],
        ];

        $subtotal = array_reduce($cartItems, function($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $serviceCharge = $subtotal * 0.1;
        $total = $subtotal + $serviceCharge;

        return view('checkout', compact('tableCode', 'cartItems', 'subtotal', 'serviceCharge', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:credit-card,debit-card,pix,cash',
            'delivery_option' => 'required|in:table,takeout',
            'observations' => 'nullable|string|max:500',
            'change_for' => 'nullable|numeric|min:0',
        ]);

        // Aqui você salvar o pedido no banco de dados
        // Por exemplo:
        // $order = Order::create([...]);

        // Simulando um ID de pedido
        $orderId = rand(1000, 9999);

        // Limpa o carrinho da sessão
        session()->forget('cart');

        return redirect()->route('order.success', ['orderId' => $orderId])
            ->with('success', 'Pedido realizado com sucesso!');
    }
}