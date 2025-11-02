<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prato;

class MenuController extends Controller
{
    public function index()
    {
        $tableCode = session('table_code', 'Mesa não identificada');
        
        // Categorias
        $categories = [
            ['id' => 'all', 'name' => 'Todos', 'icon' => '🍽️'],
            ['id' => 'starters', 'name' => 'Entradas', 'icon' => '🥗'],
            ['id' => 'main', 'name' => 'Pratos Principais', 'icon' => '🍖'],
            ['id' => 'pasta', 'name' => 'Massas', 'icon' => '🍝'],
            ['id' => 'pizza', 'name' => 'Pizzas', 'icon' => '🍕'],
            ['id' => 'drinks', 'name' => 'Bebidas', 'icon' => '🥤'],
            ['id' => 'desserts', 'name' => 'Sobremesas', 'icon' => '🍰'],
        ];

        // Buscar pratos do banco de dados
        $menuItems = Prato::disponveis()
            ->ordenados()
            ->get()
            ->map(function ($prato) {
                return [
                    'id' => $prato->id,
                    'name' => $prato->nome,
                    'description' => $prato->descricao,
                    'price' => (float) $prato->preco,
                    'category' => $prato->categoria,
                    'image' => $prato->foto_url, // Usa o accessor que retorna a URL completa
                    'available' => $prato->disponivel,
                ];
            })
            ->toArray(); // Importante: converter para array para o JavaScript

        return view('menu', compact('tableCode', 'categories', 'menuItems'));
    }
}