<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $table = 'action_logs';

    protected $fillable = [
        'action',
        'loggable_actor_type',
        'loggable_actor_id',
        'loggable_target_type',
        'loggable_target_id',
        'metadata',
    ];

    protected function casts()
    {
        return [
            'action' => 'string',
            'metadata' => 'array',
        ];
    }

    public function loggableActor()
    {
        return $this->morphTo('loggable_actor');
    }

    public function loggableTarget()
    {
        return $this->morphTo('loggable_target');
    }
}
