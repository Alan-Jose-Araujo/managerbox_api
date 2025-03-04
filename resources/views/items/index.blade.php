@extends('layouts.app')

@section('title', 'Itens em Estoque')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="container">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Gerenciar <b>Estoque</b></h2>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('items.create') }}" class="btn btn-success mr-2">
                            <i class="material-icons">&#xE147;</i> <span>Adicionar Novo Item</span>
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="material-icons">&#xe5c4;</i> Voltar para Dashboard
                        </a>
                    </div>
                </div>
            </div>
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="" method="GET">
                <div class="form-group mb-3">
                    <label for="category_id">Filtrar por Categoria:</label>
                    <select name="category_id" class="form-control" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == request()->input('category_id') ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            @if ($items->isEmpty())
                <p>Nenhum item em estoque.</p>
            @else
                <table class="table table-striped table-hover">
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
                                    <a href="{{ route('items.show', $item->id) }}" class="edit" title="Detalhes">
                                        <i class="material-icons">&#xE417;</i>
                                    </a>
                                    <a href="{{ route('items.edit', $item->id) }}" class="edit" title="Editar">
                                        <i class="material-icons">&#xE254;</i>
                                    </a>
                                    <a href="{{ route('items.movements', $item->id) }}" class="move" title="Movimentar Estoque">
                                        <i class="material-icons">&#xE8CB;</i> <!-- Ícone de movimentação -->
                                    </a>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete" title="Excluir">
                                            <i class="material-icons">&#xE872;</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
@endsection
