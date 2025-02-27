@extends('layouts.app')

@section('title', 'Itens em Estoque')

@section('content')
    <div class="container">
        <h2 class="mb-4">Itens em Estoque</h2>
        <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Adicionar Novo Item</a>

        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

        @if ($items->isEmpty())
    <p>Nenhum item em estoque.</p>
@else
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->current_quantity }}</td>
                    <td>
                        <a href="{{ route('items.show', $item->id) }}" class="btn btn-info">Detalhes</a>
                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Excluir</button>
</form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
