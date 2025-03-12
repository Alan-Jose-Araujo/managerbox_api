@extends('layouts.app')

@section('title', 'Cadastro')

@section('content')
<div class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-10 max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Registro de Usuário</h1>

            @if ($errors->any())
                <div class="text-red-500 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="multi-step-form">
                @csrf

                <!-- Step 1: Dados do Usuário -->
                <div id="step-1" class="step">
                    <h3 class="font-semibold mb-4">Dados do Usuário</h3>
                    <input type="text" name="user_name" placeholder="Nome do Usuário" class="w-full border px-3 py-2 rounded mb-2" required>
                    <input type="email" name="user_email" placeholder="Email do Usuário" class="w-full border px-3 py-2 rounded mb-2" required>
                    <input type="password" name="user_password" placeholder="Senha" class="w-full border px-3 py-2 rounded mb-2" required>
                    <input type="password" name="user_password_confirmation" placeholder="Confirme a Senha" class="w-full border px-3 py-2 rounded mb-2" required>
                    <input type="text" name="user_cpf" placeholder="CPF" class="w-full border px-3 py-2 rounded mb-2" required>
                </div>

                <!-- Step 2: Dados da Empresa -->
                <div id="step-2" class="step hidden">
                    <h3 class="font-semibold mb-4">Dados da Empresa</h3>

                    <select required class="w-full border px-3 py-2 rounded mb-4" name="company_cnae_code">
                        <option hidden selected>Área de atuação</option>
                        @foreach($metiers as $metier)
                            <option value="{{$metier->id}}">{{$metier->cnae_code}} - {{$metier->name}}</option>
                        @endforeach
                    </select>

                    <input type="text" name="company_name" placeholder="Nome da Empresa" class="w-full border px-3 py-2 rounded mb-2" required>
                    <input type="text" name="company_corporate_reason" placeholder="Razão Social" class="w-full border px-3 py-2 rounded mb-2" required>
                    <input type="email" name="company_email" placeholder="Email da Empresa" class="w-full border px-3 py-2 rounded mb-2" required>
                    <input type="text" name="company_cnpj" placeholder="CNPJ" class="w-full border px-3 py-2 rounded mb-2" required>
                    <input type="text" name="company_state_registration" placeholder="Inscrição Estadual" class="w-full border px-3 py-2 rounded mb-2" required>
                    <input type="text" name="company_landline" placeholder="Telefone Fixo da Empresa" class="w-full border px-3 py-2 rounded mb-2" value="{{ old('company_landline') }}">
                </div>

                <!-- Step 3: Endereço -->
                <div id="step-3" class="step hidden">
                    <h3 class="font-semibold mb-4">Endereço da empresa</h3>
                    <input type="text" name="zip_code" placeholder="CEP*" class="w-full border px-3 py-2 rounded mb-2" required minlength="8" maxlength="8">
                    <input type="text" name="street" placeholder="Rua*" class="w-full border px-3 py-2 rounded mb-2" minlength="4" maxlength="255" required>
                    <input type="text" name="number" placeholder="Número*" class="w-full border px-3 py-2 rounded mb-2" minlength="5" maxlength="5" required>
                    <input type="text" name="neighborhood" placeholder="Bairro*" class="w-full border px-3 py-2 rounded mb-2" min="4" maxlength="255" required>
                    <textarea name="complement" placeholder="Complemento" class="w-full border px-3 py-2 rounded mb-2" maxlength="500"></textarea>
                    <input type="text" name="city" placeholder="Cidade*" class="w-full border px-3 py-2 rounded mb-2" minlength="4" maxlength="255" required>
                    <input type="text" name="state" placeholder="Estado*" class="w-full border px-3 py-2 rounded mb-2" minlength="2" maxlength="2" required>
                </div>

                <!-- Navegação -->
                <div class="flex justify-between mt-8">
                    <button type="button" id="prevBtn" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 focus:outline-none focus:shadow-outline hidden">Anterior</button>
                    <button type="button" id="nextBtn" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:shadow-outline">Próximo</button>
                    <button type="submit" id="submitBtn" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:shadow-outline hidden">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    const form = document.getElementById('multi-step-form');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    function showStep(step) {
        document.querySelectorAll('.step').forEach(s => s.classList.add('hidden'));
        document.getElementById(`step-${step}`).classList.remove('hidden');

        prevBtn.classList.toggle('hidden', step === 1);
        nextBtn.classList.toggle('hidden', step === 3);
        submitBtn.classList.toggle('hidden', step !== 3);
    }

    function cleanAddressFields() {
        $('form#multi-step-form input[name="user_address"]').val('');
        $('form#multi-step-form input[name="user_address"]').val('');
    }

    nextBtn.addEventListener('click', () => {
        currentStep++;
        showStep(currentStep);
    });

    prevBtn.addEventListener('click', () => {
        currentStep--;
        showStep(currentStep);
    });

    showStep(currentStep);

    // Máscaras
    $(document).ready(function() {
        // Máscara para CPF
        $('input[name="user_cpf"]').mask('000.000.000-00', {reverse: true});

        // Máscara para CNPJ
        $('input[name="company_cnpj"]').mask('00.000.000/0000-00', {reverse: true});

        //Mascara para telefone Fixo com ddd
        $('input[name="company_landline"]').mask('(00)0000-0000');

        //mascara zip_code
        $('input[name="zip_code"]').mask('00000-000');

    });

    
    $(form).on('submit', function() {
        $('input[name="user_cpf"]').unmask();
        $('input[name="company_cnpj"]').unmask();
        $('input[name="company_landline"]').unmask();
        $('input[name="zip_code"]').unmask();
    });
</script>
@endsection

