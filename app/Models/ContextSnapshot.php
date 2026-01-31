<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContextSnapshot extends Model
{
    protected $fillable = [
        'decision_id',
        'data',
        'architectural_state_hash',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function decision()
    {
        return $this->belongsTo(Decision::class);
    }
}
