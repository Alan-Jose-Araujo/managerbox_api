<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshAccessTokenRequest;
use App\Models\PersonalRefreshToken;
use App\Traits\Http\SendJsonResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class AuthenticationController extends Controller
{
    use SendJsonResponses;

    public function login(LoginRequest $request)
    {
        try
        {
            $credentials = $request->only('email', 'password');

            if(!Auth::attempt($credentials)) {
                return back()->withErrors(['credentials' => 'Incorrect email or password']);
            }

            $request->session()->regenerate();
            $request->session()->regenerateToken();

            Session::put('company_id', $request->user()->company_id);

            return redirect()->route('dashboard');
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            //TODO: Adicionar redirecionamento de erro
            return $this->sendErrorResponse();
        }
    }

    public function logout(Request $request)
    {
        try
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            //TODO: Adicionar redirecionamento de erro
            return $this->sendErrorResponse();
        }
    }
}
