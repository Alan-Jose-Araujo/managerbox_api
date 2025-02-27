@extends('layouts.app')

@section('title', 'Adicionar Item')

@section('content')
    <div class="container">
        <h2>Adicionar Novo Item</h2>
        <form action="{{ url('items') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Quantidade Atual</label>
                <input type="number" name="current_quantity" class="form-control" min="0" required>
            </div>

            <div class="form-group">
                <label>Quantidade Máxima</label>
                <input type="number" name="maximum_quantity" class="form-control" min="0">
            </div>

            <div class="form-group">
                <label>Preço de Custo</label>
                <input type="number" name="cost_price" class="form-control" step="0.01" min="0">
            </div>

            <div class="form-group">
                <label>Preço de Venda</label>
                <input type="number" name="sell_price" class="form-control" step="0.01" min="0" required>
            </div>

            <div class="form-group">
                <label>Tipo de Unidade</label>
                <select name="unity_type" class="form-control">
                    <option value="U">Unidade</option>
                    <option value="KG">Quilograma</option>
                    <option value="L">Litro</option>
                </select>
            </div>

            <div class="form-group">
                <label>Localização</label>
                <input type="text" name="location" class="form-control">
            </div>

            <div class="form-group">
                <label>Imagem</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                <label class="form-check-label">Ativo</label>
            </div>

            <button type="submit" class="btn btn-success mt-3">Salvar</button>
        </form>
    </div>
@endsection
