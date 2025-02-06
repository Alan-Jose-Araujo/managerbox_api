<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'street',
        'building_number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'zipcode',
        'country',
        'addressable_type',
        'addressable_id',
    ];

    public function addressable()
    {
        return $this->morphTo('addressable');
    }
}
