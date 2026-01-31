<?php

namespace App\Services;

use App\Models\AccountabilityLedger;
use Illuminate\Support\Facades\DB;

class LedgerService
{
    /**
     * Record an action in the immutable ledger.
     */
    public function record(string $action, string $justification, ?object $entity = null, ?int $actorId = null): AccountabilityLedger
    {
        return DB::transaction(function () use ($action, $justification, $entity, $actorId) {
            $lastEntry = AccountabilityLedger::orderBy('id', 'desc')->first();
            $previousHash = $lastEntry ? $lastEntry->hash : null;

            $entry = new AccountabilityLedger([
                'entity_type' => $entity ? get_class($entity) : null,
                'entity_id' => $entity ? $entity->id : null,
                'action' => $action,
                'actor_id' => $actorId,
                'justification' => $justification,
                'previous_hash' => $previousHash,
                'created_at' => now(),
            ]);

            $entry->hash = $entry->calculateHash($previousHash);
            $entry->save();

            return $entry;
        });
    }

    /**
     * Verify the integrity of the entire ledger chain.
     */
    public function verifyChain(): bool
    {
        $entries = AccountabilityLedger::orderBy('id', 'asc')->get();
        $previousHash = null;

        foreach ($entries as $entry) {
            if ($entry->previous_hash !== $previousHash) {
                return false;
            }

            if ($entry->hash !== $entry->calculateHash($previousHash)) {
                return false;
            }

            $previousHash = $entry->hash;
        }

        return true;
    }
}
