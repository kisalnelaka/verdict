<?php

namespace App\Services;

use App\Models\Decision;
use App\Models\ContextSnapshot;
use Illuminate\Support\Facades\DB;

class DecisionService
{
    public function __construct(
        protected LedgerService $ledgerService,
        protected DriftService $driftService
    ) {
    }

    /**
     * Create a new Decision with context and record it in the ledger.
     */
    public function create(array $data, array $contextData, int $actorId, string $justification): Decision
    {
        return DB::transaction(function () use ($data, $contextData, $actorId, $justification) {
            $decision = Decision::create($data);

            ContextSnapshot::create([
                'decision_id' => $decision->id,
                'data' => $contextData,
                'architectural_state_hash' => $this->driftService->calculateStateHash(),
            ]);

            $this->ledgerService->record(
                action: 'created',
                justification: $justification,
                entity: $decision,
                actorId: $actorId
            );

            return $decision;
        });
    }

    /**
     * Transition a decision status.
     */
    public function transition(Decision $decision, string $status, int $actorId, string $justification): Decision
    {
        return DB::transaction(function () use ($decision, $status, $actorId, $justification) {
            $oldStatus = $decision->status;
            $decision->update(['status' => $status]);

            if ($status === 'resolved') {
                $decision->update(['resolved_at' => now()]);
            }

            $this->ledgerService->record(
                action: "transitioned from {$oldStatus} to {$status}",
                justification: $justification,
                entity: $decision,
                actorId: $actorId
            );

            return $decision;
        });
    }
}
