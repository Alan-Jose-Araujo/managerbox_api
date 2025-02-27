@extends('layouts.app')

@section('title', 'Detalhes do Item')

@section('content')
<link rel="stylesheet" href="{{ asset('css/form_styles.css') }}">
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Detalhes do Item</h2>
        </div>
        <div class="card-body">
            <p><strong>Nome:</strong> {{ $item->name }}</p>
            <p><strong>Descrição:</strong> {{ $item->description }}</p>
            <p><strong>Quantidade:</strong> {{ number_format($item->current_quantity, 2, ',', '.') }}</p>
            <p><strong>Preço de Custo:</strong> R$ {{ number_format($item->cost_price, 2, ',', '.') }}</p>
            <p><strong>Preço de Venda:</strong> R$ {{ number_format($item->sell_price, 2, ',', '.') }}</p>
            <p><strong>Localização:</strong> {{ $item->location }}</p>

            @if($item->picture)
                <div>
                    <img src="{{ asset('storage/' . $item->picture) }}" width="150" alt="Imagem do item">
                </div>
            @endif

            <a href="{{ route('items.index') }}" class="btn btn-secondary mt-3">Voltar</a>
        </div>
    </div>
</div>
@endsection
