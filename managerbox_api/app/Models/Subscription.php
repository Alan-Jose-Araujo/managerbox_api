<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'status',
        'start_date',
        'end_date',
        'duration',
        'payment_date',
        'company_id',
        'plan_id',
    ];

    public function isExpired()
    {
        return Carbon::parse($this->end_date)->isPast();
    }

    public function relatedCompany()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function relatedPlan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
