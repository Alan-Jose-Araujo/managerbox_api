@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
<link rel="stylesheet" href="{{ asset('css/categories_styles.css') }}">

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h2>Categorias</h2>
            </div>
            <div class="card-body">
                <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Criar Nova Categoria</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info">Detalhes</a>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Editar</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
