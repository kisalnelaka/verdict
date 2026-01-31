<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    protected $fillable = [
        'title',
        'description',
        'decision_type',
        'confidence_level',
        'status',
        'resolved_at',
    ];

    public function actors()
    {
        return $this->hasMany(DecisionActor::class);
    }

    public function snapshot()
    {
        return $this->hasOne(ContextSnapshot::class);
    }

    public function outcomes()
    {
        return $this->hasMany(Outcome::class);
    }

    public function commitLinks()
    {
        return $this->hasMany(CommitLink::class);
    }
}
