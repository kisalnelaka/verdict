<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnergyEvent extends Model
{
    protected $fillable = ['user_id', 'decision_id', 'energy_delta', 'notes'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function decision()
    {
        return $this->belongsTo(\App\Models\Decision::class);
    }
}
