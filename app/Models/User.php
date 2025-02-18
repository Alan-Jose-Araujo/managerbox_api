<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Models\UserModelAccessors;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable, UserModelAccessors;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'phone_number',
        'profile_picture_path',
        'birth_date',
        'last_activity',
        'is_active',
        'company_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $guard_name = 'api';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'profile_picture_path' => 'string',
            'last_activity' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function getRefreshToken()
    {
        return $this->hasOne(PersonalRefreshToken::class, 'user_id');
    }

    public function getRelatedcompany()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getRelatedaddress()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
