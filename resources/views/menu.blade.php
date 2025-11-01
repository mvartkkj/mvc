<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cardápio - Sabor & Cia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background" 
    x-data="{
        selectedCategory: 'all',
        searchQuery: '',
        cart: {},
        isCartOpen: false,
        menuItems: {{ Js::from($menuItems) }},
        
        get filteredItems() {
            return this.menuItems.filter(item => {
                const matchesCategory = this.selectedCategory === 'all' || item.category === this.selectedCategory;
                const matchesSearch = item.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                return matchesCategory && matchesSearch;
            });
        },
        
        get cartItemsCount() {
            return Object.values(this.cart).reduce((sum, qty) => sum + qty, 0);
        },
        
        get cartTotal() {
            return Object.entries(this.cart).reduce((sum, [itemId, qty]) => {
                const item = this.menuItems.find(i => i.id === Number(itemId));
                return sum + (item?.price || 0) * qty;
            }, 0);
        },
        
        get cartItems() {
            return Object.entries(this.cart).map(([itemId, quantity]) => {
                const item = this.menuItems.find(i => i.id === Number(itemId));
                return { ...item, quantity };
            });
        },
        
        addToCart(itemId) {
            if (!this.cart[itemId]) {
                this.cart[itemId] = 0;
            }
            this.cart[itemId]++;
        },
        
        removeFromCart(itemId) {
            if (this.cart[itemId] > 1) {
                this.cart[itemId]--;
            } else {
                delete this.cart[itemId];
            }
        },
        
        updateQuantity(itemId, quantity) {
            if (quantity === 0) {
                delete this.cart[itemId];
            } else {
                this.cart[itemId] = quantity;
            }
        }
    }">

    <!-- Header -->
    <header class="sticky top-0 z-40 border-b border-border bg-card/95 backdrop-blur">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/>
                            <path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/>
                            <path d="m2.1 21.8 6.4-6.3"/>
                            <path d="m19 5-7 7"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-foreground">Sabor & Cia</h1>
                        <p class="text-xs text-muted-foreground">{{ $tableCode }}</p>
                    </div>
                </div>
                <button @click="isCartOpen = true" class="relative bg-primary text-primary-foreground hover:bg-primary/90 px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                        <path d="M3 6h18"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                    <span x-show="cartItemsCount > 0" x-text="cartItemsCount" class="absolute -top-2 -right-2 h-6 w-6 bg-accent text-accent-foreground rounded-full flex items-center justify-center text-xs font-bold"></span>
                </button>
            </div>

            <!-- Pesquisar -->
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.3-4.3"/>
                </svg>
                <input 
                    type="search" 
                    placeholder="Buscar pratos..."
                    x-model="searchQuery"
                    class="w-full h-12 pl-10 pr-4 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring"
                />
            </div>
        </div>

        <!-- Categorias -->
        <div class="overflow-x-auto scrollbar-hide">
            <div class="container mx-auto px-4 pb-4">
                <div class="flex gap-2">
                    @foreach($categories as $category)
                    <button 
                        @click="selectedCategory = '{{ $category['id'] }}'"
                        :class="selectedCategory === '{{ $category['id'] }}' ? 'bg-primary text-primary-foreground' : 'bg-transparent border border-border hover:bg-muted'"
                        class="px-4 py-2 rounded-lg whitespace-nowrap transition-colors text-sm font-medium"
                    >
                        <span class="mr-2">{{ $category['icon'] }}</span>
                        {{ $category['name'] }}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </header>

    <!-- Menu -->
    <main class="container mx-auto px-4 py-6 pb-24">
        <div x-show="searchQuery" class="mb-4 flex items-center justify-between">
            <p class="text-sm text-muted-foreground">
                <span x-text="filteredItems.length"></span> resultado(s) para "<span x-text="searchQuery"></span>"
            </p>
            <button @click="searchQuery = ''" class="text-sm text-muted-foreground hover:text-foreground flex items-center gap-1">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"/>
                    <path d="m6 6 12 12"/>
                </svg>
                Limpar
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="item in filteredItems" :key="item.id">
                <div class="bg-card border border-border rounded-lg overflow-hidden">
                    <div class="relative h-48">
                        <img :src="item.image || '/placeholder.svg'" :alt="item.name" class="w-full h-full object-cover" />
                        <template x-if="!item.available">
                            <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                <span class="bg-destructive text-destructive-foreground px-3 py-1 rounded-full text-sm font-semibold">Indisponível</span>
                            </div>
                        </template>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <h3 class="font-semibold text-foreground text-lg" x-text="item.name"></h3>
                            <p class="text-sm text-muted-foreground leading-relaxed mt-1" x-text="item.description"></p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-primary">R$ <span x-text="item.price.toFixed(2)"></span></span>
                            <template x-if="cart[item.id]">
                                <div class="flex items-center gap-2">
                                    <button @click="removeFromCart(item.id)" class="w-8 h-8 border border-border hover:bg-muted rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"/>
                                        </svg>
                                    </button>
                                    <span class="w-8 text-center font-semibold" x-text="cart[item.id]"></span>
                                    <button @click="addToCart(item.id)" class="w-8 h-8 bg-primary text-primary-foreground hover:bg-primary/90 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"/>
                                            <path d="M12 5v14"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            <template x-if="!cart[item.id]">
                                <button @click="addToCart(item.id)" :disabled="!item.available" class="bg-primary text-primary-foreground hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"/>
                                        <path d="M12 5v14"/>
                                    </svg>
                                    Adicionar
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="filteredItems.length === 0" class="text-center py-16">
            <p class="text-muted-foreground">Nenhum item encontrado</p>
        </div>
    </main>

    <div x-show="isCartOpen" class="fixed inset-0 z-50" style="display: none;">
        <div @click="isCartOpen = false" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute right-0 top-0 bottom-0 w-full md:w-96 bg-card shadow-xl flex flex-col">
            <!-- Header -->
            <div class="border-b border-border p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                        <path d="M3 6h18"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                    <h2 class="text-xl font-bold text-foreground">Seu Pedido</h2>
                </div>
                <button @click="isCartOpen = false" class="hover:bg-muted p-2 rounded-lg">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Itens do Carrinho -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                <template x-if="cartItems.length === 0">
                    <div class="text-center py-16">
                        <svg class="w-16 h-16 text-muted-foreground mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                            <path d="M3 6h18"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                        <p class="text-muted-foreground">Seu carrinho está vazio</p>
                    </div>
                </template>
                
                <template x-for="item in cartItems" :key="item.id">
                    <div class="bg-card border border-border rounded-lg p-3">
                        <div class="flex gap-3">
                            <img :src="item.image || '/placeholder.svg'" :alt="item.name" class="w-20 h-20 object-cover rounded-lg" />
                            <div class="flex-1 space-y-2">
                                <h3 class="font-semibold text-foreground text-sm" x-text="item.name"></h3>
                                <p class="text-sm font-bold text-primary">R$ <span x-text="item.price.toFixed(2)"></span></p>
                                <div class="flex items-center gap-2">
                                    <button @click="updateQuantity(item.id, item.quantity - 1)" class="h-8 w-8 border border-border hover:bg-muted rounded-lg flex items-center justify-center">
                                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"/>
                                        </svg>
                                    </button>
                                    <span class="w-8 text-center font-semibold text-sm" x-text="item.quantity"></span>
                                    <button @click="updateQuantity(item.id, item.quantity + 1)" class="h-8 w-8 bg-primary text-primary-foreground hover:bg-primary/90 rounded-lg flex items-center justify-center">
                                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"/>
                                            <path d="M12 5v14"/>
                                        </svg>
                                    </button>
                                    <button @click="updateQuantity(item.id, 0)" class="h-8 w-8 ml-auto text-destructive hover:bg-muted rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18"/>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Footer -->
            <div x-show="cartItems.length > 0" class="border-t border-border p-4 space-y-4">
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-muted-foreground">Subtotal</span>
                        <span class="font-semibold">R$ <span x-text="cartTotal.toFixed(2)"></span></span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-muted-foreground">Taxa de serviço (10%)</span>
                        <span class="font-semibold">R$ <span x-text="(cartTotal * 0.1).toFixed(2)"></span></span>
                    </div>
                    <div class="flex items-center justify-between text-lg font-bold pt-2 border-t border-border">
                        <span>Total</span>
                        <span class="text-primary">R$ <span x-text="(cartTotal * 1.1).toFixed(2)"></span></span>
                    </div>
                </div>
                <a href="{{ route('checkout') }}" class="block">
                    <button class="w-full bg-primary text-primary-foreground hover:bg-primary/90 h-12 rounded-lg font-semibold transition-colors">
                        Finalizar Pedido
                    </button>
                </a>
            </div>
        </div>
    </div>

    <div x-show="cartItemsCount > 0" class="fixed bottom-4 left-4 right-4 md:hidden" style="display: none;">
        <button @click="isCartOpen = true" class="w-full bg-primary text-primary-foreground hover:bg-primary/90 h-14 rounded-lg text-lg font-semibold shadow-lg flex items-center justify-center gap-2">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                <path d="M3 6h18"/>
                <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            Ver Carrinho (<span x-text="cartItemsCount"></span>) • R$ <span x-text="cartTotal.toFixed(2)"></span>
        </button>
    </div>

</body>
</html>