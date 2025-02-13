<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemInStock extends Model
{
    /** @use HasFactory<\Database\Factories\ItemInStockFactory> */
    use HasFactory;

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
        'company_id'
    ];

    public function getRelatedCompany()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getCreatorUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
