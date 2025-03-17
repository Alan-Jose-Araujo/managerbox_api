@extends('layouts.app')

@section('title', 'Detalhes da Categoria')

@section('content')
<link rel="stylesheet" href="{{ asset('css/categories_styles.css') }}">

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h2>Detalhes da Categoria</h2>
            </div>
            <div class="card-body">
                <p><strong>Nome:</strong> {{ $category->name }}</p>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
@endsection
