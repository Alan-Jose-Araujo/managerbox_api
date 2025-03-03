@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow-md">
    <h2 class="text-xl font-bold mb-4">Login</h2>

    @if ($errors->any())
        <div class="text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label class="block">Email:</label>
            <input type="email" name="email" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Senha:</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
            <p>Não Possui uma conta? <a href="{{ route('register') }}">Cadastre-se aqui</a></p>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Entrar</button>
    </form>
</div>
@endsection
