<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login bem-sucedido'], 200);
            return redirect()->intended('/dashboard'); // Redireciona para a área logada
        }


        return back()->withErrors(['email' => 'As credenciais fornecidas são inválidas.']);
    }
}
