<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Metier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $metiers = Metier::all();
        return view('register')->with('metiers', $metiers);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            // Dados da empresa
            'company_name' => 'required|string|max:255',
            'company_corporate_reason' => 'required|string|max:255',
            'company_email' => 'required|email|unique:companies,email',
            'company_cnpj' => 'required|string|size:14|unique:companies,cnpj',
            'company_state_registration' => 'required|string|max:9',
            'company_foundation_date' => 'nullable|date',
            'company_landline' => 'nullable|string|max:8',
            'company_cnae_code' => 'required|integer',
            'user_phone_number' => 'nullable|string|max:20', // Agora é opcional
            'company_address_zipcode' => 'nullable|string|max:10', // Validação do CEP
            'user_address_zipcode' => 'nullable|string|max:10',

            // Dados do usuário
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:6|confirmed',
            'user_cpf' => 'required|string|size:11|unique:users,cpf',
            'user_phone_number' => 'nullable|string|max:11',
        ]);

        // Limpar o CPF, CNPJ e CEP antes de salvar no banco de dados removendo quaisquer caracteres não númericos
        $userCpf = preg_replace('/\D/', '', $request->input('user_cpf'));  
        $companyCnpj = preg_replace('/\D/', '', $request->input('company_cnpj'));
        $companyZipcode = preg_replace('/\D/', '', $request->input('company_address_zipcode'));  
        $userZipcode = preg_replace('/\D/', '', $request->input('user_address_zipcode')); 
        $companyLandline = preg_replace('/\D/', '', $request->input('company_landline'));

        // Criando a empresa
        $company = Company::create([
            'fantasy_name' => $validatedData['company_name'],
            'corporate_reason' => $validatedData['company_corporate_reason'],
            'email' => $validatedData['company_email'],
            'cnpj' => $companyCnpj,
            'state_registration' => $validatedData['company_state_registration'],
            'foundation_date' => $validatedData['company_foundation_date'] ?? null,
            'landline' => $companyLandline,
            'metier_id' => Metier::find($validatedData['company_cnae_code'])->id,
        ]);

        // Criando o usuário vinculado à empresa
        $user = User::create([
            'name' => $validatedData['user_name'],
            'email' => $validatedData['user_email'],
            'password' => Hash::make($validatedData['user_password']),
            'cpf' => $userCpf, //CPF com valores numericos
            'phone_number' => $validatedData['user_phone_number']?? null,
            'company_id' => $company->id,
        ]);

        Auth::login($user);

        Session::put('company_id', $user->company_id);

        return redirect('/dashboard');
    }
}
