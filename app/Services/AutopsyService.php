<?php

namespace App\Services;

use App\Models\Decision;
use App\Models\Outcome;

class AutopsyService
{
    /**
     * Conduct an autopsy on a specific outcome.
     */
    public function conduct(Outcome $outcome): array
    {
        $decision = $outcome->decision;
        $snapshot = $decision->snapshot;
        $findings = [];

        // Rule 1: The Arrogance Trap (Overconfidence)
        if ($outcome->severity >= 3 && $decision->confidence_level >= 80) {
            $findings[] = [
                'type' => 'overconfidence',
                'severity' => 'high',
                'message' => "Decision '{$decision->title}' had {$decision->confidence_level}% confidence but resulted in a severity {$outcome->severity} outcome.",
            ];
        }

        // Rule 2: The Ignored Warning
        $objectors = $decision->actors()->where('role', 'objector')->count();
        if ($objectors > 0) {
            $findings[] = [
                'type' => 'ignored_objections',
                'severity' => 'critical',
                'message' => "Decision was forced despite {$objectors} active objection(s). Outcome impact: {$outcome->impact_type}.",
            ];
        }

        // Rule 3: Missing Signals (Known Unknowns)
        $knownUnknowns = data_get($snapshot->data, 'known_unknowns', []);
        if (!empty($knownUnknowns) && $decision->confidence_level >= 70) {
            $findings[] = [
                'type' => 'blind_spot',
                'severity' => 'medium',
                'message' => "Decision ignored " . count($knownUnknowns) . " known unknowns while maintaining high confidence.",
            ];
        }

        return [
            'outcome_id' => $outcome->id,
            'decision_id' => $decision->id,
            'timestamp' => now()->toIso8601String(),
            'findings' => $findings,
            'verdict' => empty($findings) ? 'UNCLEAR' : 'FAILED',
        ];
    }
}
