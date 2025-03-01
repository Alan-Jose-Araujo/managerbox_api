<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $table = 'stock_movements';

    protected $fillable = [
        'quantity',
        'value',
        'company_id',
        'item_in_stock_id',
        'movement_type',
//        'supplier_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope('company', function(Builder $builder) {
            if(auth()->check()) {
                $builder->where('company_id', auth()->user()->company_id);
            }
        });
    }
}
