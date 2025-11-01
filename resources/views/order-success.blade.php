<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido Confirmado - Sabor & Cia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <div class="bg-card border border-border rounded-lg p-8 text-center space-y-6">
                <!-- Success Icon -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-500/10 rounded-full">
                    <svg class="w-10 h-10 text-green-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>

                <!-- Success Message -->
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold text-foreground">Pedido Confirmado!</h1>
                    <p class="text-muted-foreground leading-relaxed">
                        Seu pedido #{{ $orderId }} foi recebido com sucesso
                    </p>
                </div>

                <!-- Order Info -->
                <div class="bg-muted/50 border border-muted rounded-lg p-4 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-muted-foreground">Número do Pedido</span>
                        <span class="font-bold text-foreground">#{{ $orderId }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-muted-foreground">Status</span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-500/10 text-yellow-600 rounded-full text-xs font-semibold">
                            <span class="w-1.5 h-1.5 bg-yellow-600 rounded-full animate-pulse"></span>
                            Preparando
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-muted-foreground">Tempo estimado</span>
                        <span class="font-semibold text-foreground">20-30 minutos</span>
                    </div>
                </div>

                <!-- Message -->
                <div class="space-y-2">
                    <p class="text-sm text-muted-foreground leading-relaxed">
                        Estamos preparando seu pedido com todo carinho. Você será notificado quando estiver pronto!
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-3 pt-4">
                    <a href="{{ route('menu') }}" class="w-full bg-primary text-primary-foreground hover:bg-primary/90 px-6 py-3 rounded-lg font-semibold transition-colors">
                        Fazer Novo Pedido
                    </a>
                    <a href="{{ route('home') }}" class="w-full bg-transparent border border-border hover:bg-muted text-foreground px-6 py-3 rounded-lg font-semibold transition-colors">
                        Voltar ao Início
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>