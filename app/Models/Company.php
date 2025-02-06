<?php

namespace App\Models;

use App\Traits\Models\CompanyModelAccessors;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes, CompanyModelAccessors;

    protected $table = 'companies';

    protected $fillable = [
        'fantasy_name',
        'corporate_reason',
        'email',
        'email_verified_at',
        'cnpj',
        'state_registration',
        'logo_image_path',
        'foundation_date',
        'landline',
        'is_active',
        'timezone',
        'currency_code',
        'currency_decimal_places',
    ];

    protected $casts = [
        'logo_image_path' => 'string',
        'is_active' => 'boolean',
    ];

    public function employees()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
