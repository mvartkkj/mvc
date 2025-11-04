<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Sabor & Cia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #e5e5e5;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e5e5e5;
        }

        .sidebar-menu {
            padding: 16px 0;
        }

        .menu-section {
            margin-bottom: 24px;
        }

        .menu-section-title {
            padding: 0 16px;
            font-size: 11px;
            text-transform: uppercase;
            color: #737373;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .menu-item {
            padding: 10px 16px;
            display: flex;
            align-items: center;
            color: #0a0a0a;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
            font-size: 14px;
        }

        .menu-item:hover {
            background: #f5f5f5;
            border-left-color: #ea580c;
        }

        .menu-item.active {
            background: #fff7ed;
            border-left-color: #ea580c;
            color: #ea580c;
            font-weight: 500;
        }

        .menu-item-icon {
            margin-right: 12px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            background: #fafafa;
        }

        .top-bar {
            background: white;
            padding: 16px 24px;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 24px;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .card-title {
            font-size: 13px;
            color: #737373;
            font-weight: 500;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .card-icon.primary {
            background: #fff7ed;
            color: #ea580c;
        }

        .card-icon.secondary {
            background: #eff6ff;
            color: #3b82f6;
        }

        .card-icon.success {
            background: #f0fdf4;
            color: #22c55e;
        }

        .card-icon.warning {
            background: #fef3c7;
            color: #f59e0b;
        }

        .card-value {
            font-size: 28px;
            font-weight: 700;
            color: #0a0a0a;
            margin-bottom: 4px;
        }

        .card-description {
            font-size: 12px;
            color: #737373;
        }

        .content-section {
            padding: 24px;
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .content-card {
            background: white;
            padding: 24px;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
        }

        .content-card h2 {
            font-size: 20px;
            font-weight: 600;
            color: #0a0a0a;
            margin-bottom: 8px;
        }

        .content-card p {
            font-size: 14px;
            color: #737373;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        table th {
            background: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #0a0a0a;
            border-bottom: 1px solid #e5e5e5;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #e5e5e5;
            color: #0a0a0a;
            font-size: 14px;
        }

        table tr:hover {
            background: #fafafa;
        }

        .btn-logout {
            background: #ea580c;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .btn-logout:hover {
            background: #dc2626;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: #ea580c;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            font-size: 16px;
            font-weight: 700;
            color: #0a0a0a;
        }
    </style>
</head>
<body class="bg-background">
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/>
                        <path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/>
                        <path d="m2.1 21.8 6.4-6.3"/>
                        <path d="m19 5-7 7"/>
                    </svg>
                </div>
                <span class="logo-text">Sabor & Cia</span>
            </div>
            <p class="text-xs text-muted-foreground mt-1">Painel Administrativo</p>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Principal</div>
                <a class="menu-item active" data-section="dashboard">
                    <span class="menu-item-icon">📊</span>
                    Dashboard
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Gestão</div>
                <a class="menu-item" data-section="clientes">
                    <span class="menu-item-icon">👥</span>
                    Gerenciar Clientes
                </a>
                <a class="menu-item" data-section="usuarios">
                    <span class="menu-item-icon">👤</span>
                    Total de Usuários
                </a>
                <a class="menu-item" data-section="pedidos">
                    <span class="menu-item-icon">🛒</span>
                    Ver Pedidos
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Estoque</div>
                <a class="menu-item" data-section="fornecedores">
                    <span class="menu-item-icon">🚚</span>
                    Fornecedores
                </a>
                <a class="menu-item" data-section="ingredientes">
                    <span class="menu-item-icon">🧀</span>
                    Ingredientes
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Relatórios</div>
                <a class="menu-item" data-section="vendas">
                    <span class="menu-item-icon">💰</span>
                    Vendas
                </a>
                <a class="menu-item" data-section="financeiro">
                    <span class="menu-item-icon">📈</span>
                    Financeiro
                </a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div>
                <h1 class="text-xl font-semibold text-foreground">Bem-vindo de volta! 👋</h1>
                <p class="text-sm text-muted-foreground">Aqui está o resumo do seu negócio</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        </div>

        <!-- Mensagens de sucesso -->
        @if(session('success'))
        <div style="margin: 24px 24px 0 24px;">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Dashboard Overview -->
        <div id="dashboard" class="content-section active">
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Total de Clientes</span>
                        <div class="card-icon primary">👥</div>
                    </div>
                    <div class="card-value">{{ number_format($stats['total_clientes'] ?? 0) }}</div>
                    <div class="card-description">Clientes cadastrados</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Clientes Ativos</span>
                        <div class="card-icon secondary">✓</div>
                    </div>
                    <div class="card-value">{{ number_format($stats['clientes_ativos'] ?? 0) }}</div>
                    <div class="card-description">Com e-mail cadastrado</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Cadastros no Mês</span>
                        <div class="card-icon success">📅</div>
                    </div>
                    <div class="card-value">{{ number_format($stats['cadastros_mes'] ?? 0) }}</div>
                    <div class="card-description">Mês atual</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Cargos</span>
                        <div class="card-icon warning">🏷️</div>
                    </div>
                    <div class="card-value">{{ number_format($stats['total_cargos'] ?? 0) }}</div>
                    <div class="card-description">Cargos cadastrados</div>
                </div>
            </div>

            <div style="padding: 0 24px 24px 24px;">
                <div class="content-card">
                    <h2>Visão Geral do Sistema</h2>
                    <p>
                        Bem-vindo ao painel administrativo do Sabor & Cia! Aqui você pode gerenciar todos os aspectos do seu restaurante,
                        desde clientes e pedidos até fornecedores e ingredientes. Use o menu lateral para navegar entre as diferentes
                        seções do sistema.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-muted/50 rounded-lg p-4 border border-border">
                            <div class="text-2xl mb-2">📱</div>
                            <h3 class="font-semibold text-sm mb-1">Pedidos em Tempo Real</h3>
                            <p class="text-xs text-muted-foreground">Acompanhe todos os pedidos que chegam</p>
                        </div>
                        <div class="bg-muted/50 rounded-lg p-4 border border-border">
                            <div class="text-2xl mb-2">📊</div>
                            <h3 class="font-semibold text-sm mb-1">Relatórios Detalhados</h3>
                            <p class="text-xs text-muted-foreground">Análises completas de vendas</p>
                        </div>
                        <div class="bg-muted/50 rounded-lg p-4 border border-border">
                            <div class="text-2xl mb-2">🔔</div>
                            <h3 class="font-semibold text-sm mb-1">Notificações</h3>
                            <p class="text-xs text-muted-foreground">Alertas de estoque e pedidos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clientes -->
        <div id="clientes" class="content-section">
            <div class="content-card">
                <h2>Gerenciar Clientes</h2>
                <p>Lista de todos os clientes cadastrados no sistema (últimos 10).</p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Celular</th>
                            <th>Cidade</th>
                            <th>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes ?? [] as $cliente)
                        <tr>
                            <td>#{{ $cliente->cod_cliente }}</td>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->e_mail ?? '-' }}</td>
                            <td>{{ $cliente->celular ?? '-' }}</td>
                            <td>{{ $cliente->cod_cidade ?? '-' }}</td>
                            <td>
                                @if($cliente->cargo)
                                    <span class="px-2 py-1 bg-primary/10 text-primary rounded text-xs font-medium">
                                        {{ $cliente->cargo->nome }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted-foreground">Nenhum cliente cadastrado</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Usuários -->
        <div id="usuarios" class="content-section">
            <div class="content-card">
                <h2>Total de Usuários</h2>
                <p>Gerenciamento de usuários do sistema (administradores e funcionários).</p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>Admin Principal</td>
                            <td>admin@saborecia.com</td>
                            <td><span class="px-2 py-1 bg-primary/10 text-primary rounded text-xs font-medium">Administrador</span></td>
                            <td><span class="text-green-600">✓ Ativo</span></td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Carlos Gerente</td>
                            <td>carlos@saborecia.com</td>
                            <td><span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs font-medium">Gerente</span></td>
                            <td><span class="text-green-600">✓ Ativo</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pedidos -->
        <div id="pedidos" class="content-section">
            <div class="content-card">
                <h2>Ver Pedidos</h2>
                <p>Acompanhe todos os pedidos realizados em tempo real.</p>
                <table>
                    <thead>
                        <tr>
                            <th>Nº Pedido</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1234</td>
                            <td>João Silva</td>
                            <td>R$ 85,00</td>
                            <td><span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">🍕 Em preparo</span></td>
                            <td>01/11/2025 14:30</td>
                        </tr>
                        <tr>
                            <td>#1235</td>
                            <td>Maria Santos</td>
                            <td>R$ 120,00</td>
                            <td><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">🚚 Em entrega</span></td>
                            <td>01/11/2025 14:45</td>
                        </tr>
                        <tr>
                            <td>#1236</td>
                            <td>Pedro Costa</td>
                            <td>R$ 65,00</td>
                            <td><span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">✓ Entregue</span></td>
                            <td>01/11/2025 13:20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Fornecedores -->
        <div id="fornecedores" class="content-section">
            <div class="content-card">
                <h2>Fornecedores</h2>
                <p>Gerencie seus fornecedores de ingredientes e insumos.</p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Produto Principal</th>
                            <th>Telefone</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>Laticínios São Paulo</td>
                            <td>Queijos e Derivados</td>
                            <td>(11) 3456-7890</td>
                            <td><span class="text-green-600">✓ Ativo</span></td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Hortifruti Premium</td>
                            <td>Vegetais Frescos</td>
                            <td>(11) 3456-1234</td>
                            <td><span class="text-green-600">✓ Ativo</span></td>
                        </tr>
                        <tr>
                            <td>#003</td>
                            <td>Distribuidora de Carnes</td>
                            <td>Carnes e Frios</td>
                            <td>(11) 3456-5678</td>
                            <td><span class="text-green-600">✓ Ativo</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Ingredientes -->
        <div id="ingredientes" class="content-section">
            <div class="content-card">
                <h2>Ingredientes</h2>
                <p>Controle de estoque de ingredientes e alertas de reposição.</p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ingrediente</th>
                            <th>Quantidade</th>
                            <th>Unidade</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>Mussarela</td>
                            <td>45</td>
                            <td>kg</td>
                            <td><span class="text-green-600">✓ Estoque OK</span></td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Tomate</td>
                            <td>3</td>
                            <td>kg</td>
                            <td><span class="text-yellow-600">⚠ Estoque Baixo</span></td>
                        </tr>
                        <tr>
                            <td>#003</td>
                            <td>Manjericão</td>
                            <td>0.5</td>
                            <td>kg</td>
                            <td><span class="text-red-600">✕ Crítico</span></td>
                        </tr>
                        <tr>
                            <td>#004</td>
                            <td>Molho de Tomate</td>
                            <td>28</td>
                            <td>litros</td>
                            <td><span class="text-green-600">✓ Estoque OK</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Vendas -->
        <div id="vendas" class="content-section">
            <div class="content-card">
                <h2>Relatório de Vendas</h2>
                <p>Análise detalhada do desempenho de vendas do restaurante.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="border border-border rounded-lg p-4">
                        <p class="text-sm text-muted-foreground mb-1">Total de Vendas</p>
                        <p class="text-2xl font-bold text-foreground">R$ 45.200,00</p>
                        <p class="text-xs text-green-600 mt-1">↑ 23% vs mês anterior</p>
                    </div>
                    <div class="border border-border rounded-lg p-4">
                        <p class="text-sm text-muted-foreground mb-1">Ticket Médio</p>
                        <p class="text-2xl font-bold text-foreground">R$ 62,50</p>
                        <p class="text-xs text-green-600 mt-1">↑ 5% vs mês anterior</p>
                    </div>
                    <div class="border border-border rounded-lg p-4">
                        <p class="text-sm text-muted-foreground mb-1">Total de Pedidos</p>
                        <p class="text-2xl font-bold text-foreground">723</p>
                        <p class="text-xs text-green-600 mt-1">↑ 18% vs mês anterior</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financeiro -->
        <div id="financeiro" class="content-section">
            <div class="content-card">
                <h2>Relatório Financeiro</h2>
                <p>Visão geral completa do financeiro do restaurante.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="border border-border rounded-lg p-4 bg-green-50">
                        <p class="text-sm text-muted-foreground mb-1">Receita Total</p>
                        <p class="text-2xl font-bold text-green-600">R$ 45.200,00</p>
                        <p class="text-xs text-muted-foreground mt-1">Mês atual</p>
                    </div>
                    <div class="border border-border rounded-lg p-4 bg-red-50">
                        <p class="text-sm text-muted-foreground mb-1">Despesas</p>
                        <p class="text-2xl font-bold text-red-600">R$ 18.500,00</p>
                        <p class="text-xs text-muted-foreground mt-1">Mês atual</p>
                    </div>
                    <div class="border border-border rounded-lg p-4 bg-primary/5">
                        <p class="text-sm text-muted-foreground mb-1">Lucro Líquido</p>
                        <p class="text-2xl font-bold text-primary">R$ 26.700,00</p>
                        <p class="text-xs text-green-600 mt-1">↑ 31% margem</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', function(e) {
        const sectionId = this.getAttribute('data-section');
        
        // Se for "clientes", redireciona para a rota
        if (sectionId === 'clientes') {
            window.location.href = '{{ route("admin.clientes") }}';
            return;
        }
        
        // Se for "fornecedores", redireciona para a rota
        if (sectionId === 'fornecedores') {
            window.location.href = '{{ route("admin.fornecedores") }}';
            return;
        }
        
        // Se for "ingredientes", redireciona para a rota
        if (sectionId === 'ingredientes') {
            window.location.href = '{{ route("admin.ingredientes") }}';
            return;
        }
        
        e.preventDefault();
        
        document.querySelectorAll('.menu-item').forEach(mi => mi.classList.remove('active'));
        this.classList.add('active');
        
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });
        
        document.getElementById(sectionId).classList.add('active');
    });
});

        // Manter aba ativa se vier de search/paginação
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search') || urlParams.has('page')) {
            document.querySelectorAll('.menu-item').forEach(mi => mi.classList.remove('active'));
            document.querySelector('[data-section="clientes"]').classList.add('active');
            
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById('clientes').classList.add('active');
        }
    </script>
</body>
</html>