<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemInStock extends Model
{
    /** @use HasFactory<\Database\Factories\ItemInStockFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'items_in_stock';

    protected $fillable = [
        'sku_code',
        'barcode',
        'name',
        'description',
        'unity_type',
        'current_quantity',
        'maximum_quantity',
        'cost_price',
        'sell_price',
        'picture',
        'location',
        'is_active',
        'company_id',
        'category_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            if(auth()->check()) {
                $builder->where('company_id', auth()->user()->company_id);
            }
        });

        static::created(function (ItemInStock $itemInStock) {
            ActionLog::create([
                'action' => 'created',
                'loggable_actor_type' => User::class,
                'loggable_actor_id' => auth()->user()->id,
                'loggable_target_type' => ItemInStock::class,
                'loggable_target_id' => $itemInStock->id,
            ]);
        });
    }

    public function relatedCompany()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    // Relacionamento com StockMovement
    public function movements()
    {
        return $this->hasMany(StockMovement::class, 'item_in_stock_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
