@extends('layouts.app')

@section('title', 'Editar Item')

@section('content')
<link rel="stylesheet" href="{{ asset('css/form_styles.css') }}">
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Editar Item</h2>
        </div>
        <div class="card-body">
            <form action="{{ url('items/' . $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                </div>

                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="description" class="form-control">{{ $item->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Quantidade Atual</label>
                    <input type="number" name="current_quantity" class="form-control" value="{{ $item->current_quantity }}" min="0" required>
                </div>

                <div class="form-group">
                    <label>Quantidade Máxima</label>
                    <input type="number" name="maximum_quantity" class="form-control" value="{{ $item->maximum_quantity }}" min="0">
                </div>

                <div class="form-group">
                    <label>Preço de Custo</label>
                    <input type="number" name="cost_price" class="form-control" step="0.01" min="0" value="{{ $item->cost_price }}">
                </div>

                <div class="form-group">
                    <label>Preço de Venda</label>
                    <input type="number" name="sell_price" class="form-control" step="0.01" min="0" value="{{ $item->sell_price }}" required>
                </div>

                <div class="form-group">
                    <label>Tipo de Unidade</label>
                    <select name="unity_type" class="form-control">
                        <option value="U" {{ $item->unity_type == 'U' ? 'selected' : '' }}>Unidade</option>
                        <option value="KG" {{ $item->unity_type == 'KG' ? 'selected' : '' }}>Quilograma</option>
                        <option value="L" {{ $item->unity_type == 'L' ? 'selected' : '' }}>Litro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Localização</label>
                    <input type="text" name="location" class="form-control" value="{{ $item->location }}">
                </div>

                <div class="form-group">
                    <label>Imagem Atual</label>
                    @if($item->picture)
                        <div>
                            <img src="{{ asset('storage/' . $item->picture) }}" width="100" alt="Imagem do item">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">Ativo</label>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Atualizar</button>
            </form>
        </div>
    </div>
</div>
@endsection
