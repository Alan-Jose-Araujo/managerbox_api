@extends('layouts.app')

@section('title', 'Criar Categoria')

@section('content')
<link rel="stylesheet" href="{{ asset('css/categories_styles.css') }}">

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h2>Criar Categoria</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Nome da Categoria:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Criar Categoria</button>
                </form>
            </div>
        </div>
    </div>
@endsection
