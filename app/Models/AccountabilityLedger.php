<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountabilityLedger extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'entity_type',
        'entity_id',
        'action',
        'actor_id',
        'justification',
        'hash',
        'previous_hash',
        'created_at',
    ];

    public function calculateHash(string $previousHash = null): string
    {
        $data = [
            $this->entity_type,
            $this->entity_id,
            $this->action,
            $this->actor_id,
            $this->justification,
            $previousHash,
            $this->created_at,
        ];

        return hash('sha256', json_encode($data));
    }
}
