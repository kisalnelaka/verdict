<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommitLink extends Model
{
    protected $fillable = [
        'decision_id',
        'commit_hash',
        'author',
        'message',
        'committed_at',
    ];

    public function decision()
    {
        return $this->belongsTo(Decision::class);
    }
}
