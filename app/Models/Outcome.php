<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $fillable = [
        'decision_id',
        'impact_type',
        'severity',
        'measurable_delta',
        'metadata',
        'occurred_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'occurred_at' => 'datetime',
    ];

    public function decision()
    {
        return $this->belongsTo(Decision::class);
    }
}
