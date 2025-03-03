@extends('layouts.app')

@section('title', 'Movimentação de Estoque')

@section('content')

<div class="container">
    <h2>Movimentação de Estoque - {{ $item->name }}</h2>
    
    <!-- Histórico de movimentações -->
    <h4>Histórico</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movements as $movement)
                <tr>
                    <td>{{ $movement->movement_type == 'checkin' ? 'Entrada' : 'Saída' }}</td>
                    <td>{{ $movement->quantity }}</td>
                    <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Formulário de Movimentação -->
    <h4>Nova Movimentação</h4>
    <form action="{{ route('items.movements.store', $item->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="movement_type">Tipo de Movimentação:</label>
            <select name="movement_type" class="form-control" required>
                <option value="checkin">Entrada</option>
                <option value="checkout">Saída</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="quantity">Quantidade:</label>
            <input type="number" name="quantity" class="form-control" required min="1" step="0.01">
        </div>
        
        <button type="submit" class="btn btn-primary">Registrar Movimentação</button>
        
    </form>

    <a href="{{ route('items.index') }}" class="btn btn-secondary">
    <i class="material-icons">&#xe5c4;</i> Voltar para Listagem
</a>
</div>

@endsection
