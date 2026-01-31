<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DecisionActor extends Model
{
    protected $fillable = [
        'decision_id',
        'user_id',
        'role',
        'objections',
    ];

    public function decision()
    {
        return $this->belongsTo(Decision::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
