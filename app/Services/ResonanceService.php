<?php

namespace App\Services;

use App\Models\Decision;
use App\Models\CommitLink;
use App\Models\Outcome;

class ResonanceService
{
    /**
     * Calculate the "Resonance Score" for a decision.
     * Higher is better (high output, low severity).
     */
    public function calculateResonance(Decision $decision): array
    {
        $commitCount = $decision->commitLinks()->count();
        $outcomes = $decision->outcomes;

        $severitySum = $outcomes->sum('severity');
        $averageSeverity = $outcomes->count() > 0 ? $severitySum / $outcomes->count() : 0;

        // Low output (< 3 commits) = Indeterminate Resonance
        if ($commitCount < 3) {
            return ['status' => 'UNDETERMINED', 'score' => 0];
        }

        // Toxic Resonance: High output (> 10 commits) but high severity (> 4)
        if ($commitCount > 10 && $averageSeverity >= 4) {
            return ['status' => 'TOXIC', 'score' => -100];
        }

        // Positive Resonance: Good output and low severity
        if ($commitCount > 5 && $averageSeverity < 2) {
            return ['status' => 'HARMONIOUS', 'score' => 100];
        }

        return ['status' => 'STABLE', 'score' => 50];
    }
}
