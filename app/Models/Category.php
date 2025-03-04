<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company_id'];

    public function items()
    {
        return $this->hasMany(ItemInStock::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('company', function(Builder $builder) {
            if(Auth::check()) {
                $builder->where('company_id', Session::get('company_id'));
            }
        });
    }
}

