<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PersonalRefreshToken extends Model
{
    protected $table = 'personal_refresh_tokens';

    protected $fillable = [
        'token',
        'user_id',
        'expires_at'
    ];

    public static function generate($user)
    {
        return self::create([
            'token' => Str::random(64),
            'user_id' => $user->id,
            'expires_at' => now()->addMinutes(config('sanctum.refresh_token_expiration'))
        ]);
    }

    public function getRelatedUser()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
