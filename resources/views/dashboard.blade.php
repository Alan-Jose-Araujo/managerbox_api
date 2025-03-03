<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-gray-900 text-white w-64 space-y-6 py-7 px-2">
            <div class="text-center text-2xl font-semibold">Inventory System</div>
            <nav>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('items.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">Gerenciar Itens</a>
                
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-semibold">Bem-vindo, {{ auth()->user()->name }}!</h1>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Sair</button>
                </form>
            </div>
            
            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold">Total de Produtos</h2>
                    <p class="text-gray-600 text-2xl">{{ $totalItemsInStock }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold">Movimentações Recentes</h2>
                    <p class="text-gray-600 text-2xl">{{ $totalStockMovements }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold">Produtos em Baixa</h2>
                    <p class="text-gray-600 text-2xl">{{ $lowStockCount }}</p>
                </div>
            </div>
            
            <!-- Tabela de Itens -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-lg font-bold">Itens em Estoque</h2>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Nome</th>
                            <th class="py-2 px-4 border-b">Quantidade</th>
                            <th class="py-2 px-4 border-b">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $item->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->current_quantity }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('items.show', $item->id) }}" class="text-blue-500">Detalhes</a>
                                    <a href="{{ route('items.movements', $item->id) }}" class="text-blue-500">Movimentações</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Tabela de Movimentações -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-bold mb-4">Últimas Movimentações</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Produto</th>
                                <th class="py-2 px-4 border-b">Quantidade</th>
                                <th class="py-2 px-4 border-b">Tipo</th>
                                <th class="py-2 px-4 border-b">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($movements as $movement)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $movement->item?->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $movement->quantity }}</td>
                                    <td class="py-2 px-4 border-b">{{ $movement->movement_type }}</td>
                                    <td class="py-2 px-4 border-b">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
