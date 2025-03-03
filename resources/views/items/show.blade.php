@extends('layouts.app')

@section('title', 'Detalhes do Item')

@section('content')
<link rel="stylesheet" href="{{ asset('css/form_styles.css') }}">

<div class="md:flex items-start justify-center py-12 2xl:px-20 md:px-6 px-4">
    <div class="xl:w-2/6 lg:w-2/5 w-80 md:block hidden">
        @if($item->picture)
            <img class="w-full" alt="{{ $item->name }}" src="{{ asset($item->picture) }}" />
        @else
            <img class="w-full" alt="Sem imagem" src="{{ asset('images/no-image.png') }}" />
        @endif
    </div>
    <div class="md:hidden">
        @if($item->picture)
            <img class="w-full" alt="{{ $item->name }}" src="{{ asset($item->picture) }}" />
        @else
            <img class="w-full" alt="Sem imagem" src="{{ asset('images/no-image.png') }}" />
        @endif
    </div>
    <div class="xl:w-2/5 md:w-1/2 lg:ml-8 md:ml-6 md:mt-0 mt-6">
        <div class="border-b border-gray-200 pb-6">
            <h1 class="lg:text-2xl text-xl font-semibold lg:leading-6 leading-7 text-gray-800">{{ $item->name }}</h1>
        </div>
        <div class="py-4 border-b border-gray-200 flex items-center justify-between">
            <p class="text-base leading-4 text-gray-800">Quantidade</p>
            <div class="flex items-center justify-center">
                <p class="text-sm leading-none text-gray-600">{{ number_format($item->current_quantity, 2, ',', '.') }}</p>
            </div>
        </div>
        <div class="py-4 border-b border-gray-200 flex items-center justify-between">
            <p class="text-base leading-4 text-gray-800">Preço de Custo</p>
            <div class="flex items-center justify-center">
                <p class="text-sm leading-none text-gray-600">R$ {{ number_format($item->cost_price, 2, ',', '.') }}</p>
            </div>
        </div>
        <div class="py-4 border-b border-gray-200 flex items-center justify-between">
            <p class="text-base leading-4 text-gray-800">Preço de Venda</p>
            <div class="flex items-center justify-center">
                <p class="text-sm leading-none text-gray-600">R$ {{ number_format($item->sell_price, 2, ',', '.') }}</p>
            </div>
        </div>
        <div>
            <p class="xl:pr-48 text-base lg:leading-tight leading-normal text-gray-600 mt-7">{{ $item->description }}</p>
            <p class="text-base leading-4 mt-7 text-gray-600">Localização: {{ $item->location }}</p>
        </div>
        <div class="flex justify-between mt-5">
            <a href="{{ route('items.index') }}" class="btn btn-secondary">Voltar</a>
            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary">Editar</a>
        </div>
    </div>
</div>
@endsection
