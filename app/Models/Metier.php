<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metier extends Model
{
    use HasFactory;

    protected $table = 'metiers';

    protected $fillable = [
        'name',
        'cnae_code'
    ];

    public function getRelatedCompanies()
    {
        return $this->hasMany(Company::class, 'metier_id');
    }
}
