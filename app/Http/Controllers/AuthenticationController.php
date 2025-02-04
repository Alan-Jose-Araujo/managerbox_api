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

class AuthenticationController extends Controller
{
    use SendJsonResponses;

    public function login(LoginRequest $request)
    {
        try
        {
            $credentials = $request->only('email', 'password');

            if(!Auth::attempt($credentials)) {
                return $this->sendBadRequestResponse(
                    'Bad Request',
                    ['credentials' => 'Incorrect email or password']
                );
            }

            $user = Auth::user();

            $accessToken = $user->createToken(
                'access_token',
                expiresAt: now()->addMinutes(config('sanctum.expiration'))
            )->plainTextToken;

            $refreshToken = PersonalRefreshToken::generate($user);

            return $this->sendResponse([
                'success' => true,
                'access_token' => $accessToken,
            ])->cookie('refresh_token', $refreshToken->token, 60 * 24 * 7, null, true, true);
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return $this->sendErrorResponse();
        }
    }

    public function refreshToken(RefreshAccessTokenRequest $request)
    {
        try
        {
            $refreshToken = PersonalRefreshToken::where('token', $request->input('refresh_token'))->first();

            if(is_null($refreshToken) || $refreshToken->expires_at->isPast()) {
                return $this->sendResponse([
                    'success' => false,
                    'errors' => [
                        'refresh_token' => 'Invalid or expired refresh token'
                    ]
                ], 401);
            }

            $user = $refreshToken->user;

            $refreshToken->delete();

            $newRefreshToken = PersonalRefreshToken::generate($user);
            $accessToken = $user->createToken('access_token')->plainTextToken;

            return $this->sendResponse([
                'success' => true,
                'access_token' => $accessToken,
            ])->cookie('refresh_token', $newRefreshToken->token, 60 * 24 * 7, null, true, true);
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return $this->sendErrorResponse();
        }
    }

    public function logout(Request $request)
    {
        try
        {
            $user = $request->user();
            $user->refreshToken->delete();
            $user->tokens()->delete();
            return $this->sendResponse([
                'success' => true,
            ]);
        }
        catch(\Exception $exception)
        {
            Log::error($exception);
            return $this->sendErrorResponse();
        }
    }
}
