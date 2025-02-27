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
                    <div class="col-sm-6">
                    <a href="{{ route('items.create') }}" class="btn btn-success">
    <i class="material-icons">&#xE147;</i> <span>Adicionar Novo Item</span>
</a>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if ($items->isEmpty())
                <p>Nenhum item em estoque.</p>
            @else
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><span>ID</span></th>
                            <th><span>Nome</span></th>
                            <th><span>Quantidade</span></th>
                            <th><span>Ações</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->current_quantity }}</td>
                                <td>
                                    <a href="{{ route('items.show', $item->id) }}" class="edit" title="Detalhes" data-toggle="tooltip">
                                        <i class="material-icons">&#xE417;</i>
                                    </a>
                                    <a href="{{ route('items.edit', $item->id) }}" class="edit" title="Editar" data-toggle="tooltip">
                                        <i class="material-icons">&#xE254;</i>
                                    </a>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete" title="Excluir" data-toggle="tooltip">
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
