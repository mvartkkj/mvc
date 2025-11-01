<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $tableCode = session('table_code', 'Mesa não identificada');
        
        // Mock data - substitua por consulta ao banco de dados
        $categories = [
            ['id' => 'all', 'name' => 'Todos', 'icon' => '🍽️'],
            ['id' => 'starters', 'name' => 'Entradas', 'icon' => '🥗'],
            ['id' => 'main', 'name' => 'Pratos Principais', 'icon' => '🍖'],
            ['id' => 'pasta', 'name' => 'Massas', 'icon' => '🍝'],
            ['id' => 'pizza', 'name' => 'Pizzas', 'icon' => '🍕'],
            ['id' => 'drinks', 'name' => 'Bebidas', 'icon' => '🥤'],
            ['id' => 'desserts', 'name' => 'Sobremesas', 'icon' => '🍰'],
        ];

        $menuItems = [
            [
                'id' => 1,
                'name' => 'Bruschetta Italiana',
                'description' => 'Pão italiano tostado com tomate, manjericão e azeite',
                'price' => 24.90,
                'category' => 'starters',
                'image' => '/images/classic-bruschetta.png',
                'available' => true,
            ],
            [
                'id' => 2,
                'name' => 'Salada Caesar',
                'description' => 'Alface romana, croutons, parmesão e molho caesar',
                'price' => 32.90,
                'category' => 'starters',
                'image' => '/images/caesar-salad.png',
                'available' => true,
            ],
            [
                'id' => 3,
                'name' => 'Picanha na Brasa',
                'description' => '300g de picanha grelhada com arroz, farofa e vinagrete',
                'price' => 89.90,
                'category' => 'main',
                'image' => '/images/grilled-picanha.png',
                'available' => true,
            ],
            [
                'id' => 4,
                'name' => 'Salmão Grelhado',
                'description' => 'Filé de salmão com legumes e molho de maracujá',
                'price' => 79.90,
                'category' => 'main',
                'image' => '/images/grilled-salmon-plate.png',
                'available' => true,
            ],
            [
                'id' => 5,
                'name' => 'Espaguete Carbonara',
                'description' => 'Massa fresca com bacon, ovos, parmesão e pimenta',
                'price' => 54.90,
                'category' => 'pasta',
                'image' => '/images/spaghetti-carbonara.png',
                'available' => true,
            ],
            [
                'id' => 6,
                'name' => 'Lasanha Bolonhesa',
                'description' => 'Camadas de massa, molho bolonhesa e queijo gratinado',
                'price' => 49.90,
                'category' => 'pasta',
                'image' => '/images/lasagna-bolognese.png',
                'available' => true,
            ],
            [
                'id' => 7,
                'name' => 'Pizza Margherita',
                'description' => 'Molho de tomate, mussarela, manjericão e azeite',
                'price' => 45.90,
                'category' => 'pizza',
                'image' => '/images/margherita-pizza.png',
                'available' => true,
            ],
            [
                'id' => 8,
                'name' => 'Pizza Calabresa',
                'description' => 'Calabresa, cebola, mussarela e azeitonas',
                'price' => 48.90,
                'category' => 'pizza',
                'image' => '/images/pepperoni-pizza.png',
                'available' => true,
            ],
            [
                'id' => 9,
                'name' => 'Refrigerante Lata',
                'description' => 'Coca-Cola, Guaraná ou Sprite - 350ml',
                'price' => 6.90,
                'category' => 'drinks',
                'image' => '/images/soda-can.png',
                'available' => true,
            ],
            [
                'id' => 10,
                'name' => 'Suco Natural',
                'description' => 'Laranja, limão ou maracujá - 500ml',
                'price' => 12.90,
                'category' => 'drinks',
                'image' => '/images/fresh-juice.png',
                'available' => true,
            ],
            [
                'id' => 11,
                'name' => 'Tiramisu',
                'description' => 'Sobremesa italiana com café, mascarpone e cacau',
                'price' => 28.90,
                'category' => 'desserts',
                'image' => '/images/classic-tiramisu.png',
                'available' => true,
            ],
            [
                'id' => 12,
                'name' => 'Petit Gateau',
                'description' => 'Bolinho de chocolate quente com sorvete de baunilha',
                'price' => 32.90,
                'category' => 'desserts',
                'image' => '/images/chocolate-lava-cake.png',
                'available' => true,
            ],
        ];

        return view('menu', compact('tableCode', 'categories', 'menuItems'));
    }
}
