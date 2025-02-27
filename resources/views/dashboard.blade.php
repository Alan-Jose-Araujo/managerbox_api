<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo, {{ auth()->user()->name }}!</h1>

    <div class="bg-white p-4 shadow rounded">
    <h2 class="text-lg font-bold">Últimos Itens Cadastrados</h2>
    <ul>
        @foreach ($items as $item)
            <li class="border-b py-2">
                <strong>{{ $item->name }}</strong> - {{ $item->current_quantity }} unidades
                <a href="{{ route('items.show', $item->id) }}" class="text-blue-500">Ver</a>
            </li>
        @endforeach
    </ul>
</div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Sair</button>
    </form>
    <a href="{{ route('items.index') }}" class="block bg-blue-500 text-white px-4 py-2 rounded text-center">Gerenciar Itens</a>

</body>
</html>
