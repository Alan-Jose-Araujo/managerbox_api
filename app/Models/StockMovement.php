<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $table = 'stock_movements';

    protected $fillable = [
        'movement_type',
        'quantity',
        'value',
        'company_id',
        'user_id',
        'item_in_stock_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope('company', function(Builder $builder) {
            if(auth()->check()) {
                $builder->where('company_id', auth()->user()->company_id);
            }
        });
    }

    // Relacionamento com ItemInStock
    public function item()
    {
        return $this->belongsTo(ItemInStock::class, 'item_in_stock_id');
    }

    // Novo relacionamento com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
