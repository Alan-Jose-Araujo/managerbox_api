@extends('layouts.app')

@section('title', 'Editar Categoria')

@section('content')
<link rel="stylesheet" href="{{ asset('css/categories_styles.css') }}">

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h2>Editar Categoria</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="name">Nome da Categoria:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $category->name }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar Categoria</button>
                </form>
            </div>
        </div>
    </div>
@endsection
