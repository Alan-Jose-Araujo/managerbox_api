<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

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
}
